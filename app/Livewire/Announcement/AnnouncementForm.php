<?php

namespace App\Livewire\Announcement;

use App\Jobs\SendWhatsappJob;
use App\Livewire\BaseComponent;
use App\Models\Announcement;
use App\Models\Employee;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class AnnouncementForm extends BaseComponent
{
    use LivewireAlert;

    public $subject;
    public $recipient;
    public $recipients = [];
    public $description;

    protected $rules = [
        'subject' => 'required',
        'recipient' => 'required',
        'description' => 'required',
    ];

    public function resetForm()
    {
        $this->subject = '';
        $this->recipient = '';
        $this->description = '';
    }

    public function mount()
    {
        $this->resetForm();
        $roles = Role::all()->pluck('name');
        $roles = $roles->push('Employee');
        $this->recipients = $roles->toArray();

        // dd($this->recipients);
    }

    public function submit()
    {
        $this->validate();

        try {

            $recipients = [];

            $announcement = Announcement::create([
                'subject' => $this->subject,
                'description' => $this->description,
                'user_id' => $this->authUser->id
            ]);

            if ($this->recipient == 'Employee') {
                $type = 'employee';
                $recipients = Employee::all();
            } else {
                $type = 'user';
                $recipients = User::role($this->recipient)->get();
            }

            $message = "🔔 *Announcement!*\n
            *Subject:* " . $announcement->subject . "\n
            *Description:* " . $announcement->description;

            foreach ($recipients as $recipient) {
                $phone = $recipient->phone;

                if ($phone != null) {
                    dispatch(new SendWhatsappJob($phone, $message));

                    $announcement->recipients()->create([
                        'recipientable_id' => $recipient->id,
                        'recipientable_type' => $type,
                        'name' => $recipient->name,
                        'phone' => $recipient->phone,
                    ]);
                }
            }

            $this->alert('success', 'Announcement created successfully');
            $this->resetForm();
            return redirect()->route('announcement');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.announcement.announcement-form')->layout('layouts.app', ['title' => 'Announcement Create']);
    }
}
