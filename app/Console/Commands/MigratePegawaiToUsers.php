<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigratePegawaiToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
    * --delete : delete pegawai rows after successful migration
    * --drop-table : drop the `pegawai` table after successful migration and deletion
    * --dry-run : only show what would be done
     *
     * @var string
     */
    protected $signature = 'migrate:pegawai-to-users {--delete} {--drop-table} {--dry-run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import pegawai records into users table and assign role (default: user)';

    public function handle()
    {
        $delete = $this->option('delete');
        $dryRun = $this->option('dry-run');

        $this->info('Starting pegawai -> users migration');

        $pegawaiList = Pegawai::orderBy(Pegawai::nameColumn())->get();
        $created = 0;
        $updated = 0;
        $skipped = 0;

        DB::beginTransaction();
        try {
            foreach ($pegawaiList as $peg) {
                $email = trim($peg->email ?? '');

                if (empty($email)) {
                    $this->line("Skipping pegawai id={$peg->id} (no email)");
                    $skipped++;
                    continue;
                }

                $existing = User::where('email', $email)->first();

                if ($existing) {
                    // update bidang/jabatan if empty
                    $changed = false;
                    if (empty($existing->bidang) && !empty($peg->bidang)) {
                        $existing->bidang = $peg->bidang;
                        $changed = true;
                    }
                    if (empty($existing->jabatan) && !empty($peg->jabatan)) {
                        $existing->jabatan = $peg->jabatan;
                        $changed = true;
                    }

                    if ($changed) {
                        if ($dryRun) {
                            $this->line("Would update existing user {$existing->email} with bidang/jabatan from pegawai id={$peg->id}");
                        } else {
                            $existing->save();
                            $this->line("Updated existing user {$existing->email} with bidang/jabatan");
                        }
                        $updated++;
                    } else {
                        $this->line("No changes for existing user {$existing->email}; skipping");
                        $skipped++;
                    }

                    // If --delete provided, remove the pegawai row even when user already exists
                    if ($delete && !$dryRun) {
                        try {
                            $peg->delete();
                            $this->line("Deleted pegawai id={$peg->id} (existing user)");
                        } catch (\Exception $e) {
                            $this->line("Failed to delete pegawai id={$peg->id}: " . $e->getMessage());
                        }
                    } else {
                        if ($delete && $dryRun) {
                            $this->line("Would delete pegawai id={$peg->id} (existing user)");
                        }
                    }

                    continue;
                }

                // create new user
                $userAttributes = [
                    'name' => $peg->nama ?? $email,
                    'email' => $email,
                    // default role for migrated pegawai
                    'role' => 'user',
                    'bidang' => $peg->bidang,
                    'jabatan' => $peg->jabatan,
                    // create a random password; administrators can trigger password reset for new users
                    'password' => Hash::make(Str::random(12)),
                ];

                if ($dryRun) {
                    $this->line("Would create user for pegawai id={$peg->id} email={$email}");
                    $created++;
                } else {
                    User::create($userAttributes);
                    $this->line("Created user for pegawai id={$peg->id} email={$email}");
                    $created++;
                }

                if ($delete && !$dryRun) {
                    $peg->delete();
                    $this->line("Deleted pegawai id={$peg->id}");
                }
            }

            if ($dryRun) {
                DB::rollBack();
            } else {
                DB::commit();
            }

            // If requested, drop the pegawai table after successful migration and deletion.
            $dropTable = $this->option('drop-table');
            if ($dropTable) {
                if ($dryRun) {
                    $this->line("[dry-run] Would drop table `pegawai` if conditions met.");
                } else {
                    if (!Schema::hasTable('pegawai')) {
                        $this->line("Table `pegawai` does not exist; nothing to drop.");
                    } else {
                        $remaining = Pegawai::count();
                        if ($remaining > 0 && !$delete) {
                            $this->line("Refusing to drop `pegawai` because it still has $remaining rows. Use --delete to remove rows before dropping.");
                        } else {
                            try {
                                Schema::drop('pegawai');
                                $this->line("Dropped table `pegawai` successfully.");
                            } catch (\Exception $e) {
                                $this->line("Failed to drop `pegawai`: " . $e->getMessage());
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error during migration: ' . $e->getMessage());
            return 1;
        }

        $this->info("Done. Created: $created, Updated: $updated, Skipped: $skipped");
        if ($dryRun) {
            $this->info('Dry-run mode; no changes were persisted.');
        }

        return 0;
    }
}
