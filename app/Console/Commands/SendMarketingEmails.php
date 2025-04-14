<?php
// app/Console/Commands/SendMarketingEmails.php
namespace App\Console\Commands;

use App\Mail\MarketingReportMail;
use App\Models\Marketing;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMarketingEmails extends Command
{
    protected $signature = 'marketing:send-emails';
    protected $description = 'Send weekly marketing report emails';

    public function handle(): void {
        $marketings = Marketing::where('should_send_mail', true)->get();

        foreach ($marketings as $marketing) {
            try {
                Mail::to($marketing->email)->send(new MarketingReportMail($marketing));
                $this->info("Email sent successfully to: {$marketing->email}");
            } catch (\Exception $e) {
                $this->error("Failed to send email to: {$marketing->email}. Error: {$e->getMessage()}");
            }
        }

        $this->info('Marketing emails processing completed.');
    }
}
