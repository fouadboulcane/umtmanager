<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);

        $this->call(AnouncementSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(DeviSeeder::class);
        $this->call(DeviRequestSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(ExpenseSeeder::class);
        $this->call(InvoiceSeeder::class);
        $this->call(LeaveSeeder::class);
        $this->call(ManifestSeeder::class);
        $this->call(NoteSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(PresenceSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(SocialLinkSeeder::class);
        $this->call(TaskSeeder::class);
        $this->call(TeamMemberSeeder::class);
        $this->call(TicketSeeder::class);
        $this->call(MessageSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UserMetaSeeder::class);
    }
}
