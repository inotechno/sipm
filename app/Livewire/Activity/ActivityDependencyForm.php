<?php

namespace App\Livewire\Activity;

use App\Jobs\SendWhatsappJob;
use App\Livewire\BaseComponent;
use App\Models\ActivityIssue;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ActivityDependencyForm extends BaseComponent
{
    use LivewireAlert;
    public $activity;
    public $activity_id;
    public $dependencies = []; // Array untuk menyimpan input
    public $category_dependencies = []; // Data category dependencies
    public $deletedIds = []; // Track IDs of deleted dependencies
    public $isEditSolution = true;

    protected $rules = [
        'dependencies.*.id' => 'nullable|exists:activity_issues,id',
        'dependencies.*.date' => 'required|date',
        'dependencies.*.category_dependency_id' => 'required|exists:category_dependencies,id',
        'dependencies.*.percentage_dependency' => 'required|numeric|min:0|max:100',
        'dependencies.*.description' => 'nullable|string|max:255',
        'dependencies.*.solution' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'dependencies.*.date.required' => 'Tanggal harus diisi.',
        'dependencies.*.category_dependency_id.required' => 'Kategori harus dipilih.',
        'dependencies.*.percentage_dependency.required' => 'Persentase harus diisi.',
        'dependencies.*.percentage_dependency.numeric' => 'Persentase harus berupa angka.',
        'dependencies.*.percentage_dependency.min' => 'Persentase minimal adalah 0.',
        'dependencies.*.percentage_dependency.max' => 'Persentase maksimal adalah 100.',
        'dependencies.*.description.max' => 'Solusi maksimal 255 karakter.',
        'dependencies.*.solution.max' => 'Solusi maksimal 255 karakter.',
    ];

    public function mount($activity_id = null)
    {
        if ($activity_id == null) {
            return abort(404);
        }

        $this->activity = \App\Models\Activity::find($activity_id);
        $this->activity_id = $activity_id;
        $this->dependencies = $this->activity->issues->map(function ($issue) {
            return [
                'id' => $issue->id,
                'date' => $issue->date ?? null, // default jika null
                'category_dependency_id' => $issue->category_dependency_id ?? null, // default jika null
                'description' => $issue->description ?? null, // default jika null
                'solution' => $issue->solution ?? null, // default jika null
                'percentage_dependency' => $issue->percentage_dependency ?? null, // default jika null
            ];
        })->toArray();
        // dd($this->activity_id);
        // $this->dependencies = ActivityIssue::where('activity_id', $this->activity_id)
        //     ->get()
        //     ->map(function ($issue) {
        //         return [
        //             'id' => $issue->id,
        //             'date' => $issue->date ?? null, // default jika null
        //             'category_dependency_id' => $issue->category_dependency_id ?? null, // default jika null
        //             'description' => $issue->description ?? null, // default jika null
        //             'percentage_dependency' => $issue->percentage_dependency ?? null, // default jika null
        //         ];
        //     })
        //     ->toArray();

        if ($this->authUser->hasRole('Supervisor')) {
            $this->isEditSolution = false;
        }

        // Ambil data category dependencies (contoh)
        $this->category_dependencies = \App\Models\CategoryDependency::all();
    }

    public function addDependency()
    {
        $this->dependencies[] = [
            'id' => '',
            'date' => '',
            'category_dependency_id' => '',
            'description' => '',
            'solution' => '',
        ];
    }

    public function removeDependency($index)
    {
        // If the dependency has an ID, add it to deletedIds array
        if (isset($this->dependencies[$index]['id'])) {
            $this->deletedIds[] = $this->dependencies[$index]['id'];
        }

        unset($this->dependencies[$index]);
        $this->dependencies = array_values($this->dependencies);
    }

    public function resetForm()
    {
        $this->dependencies = [
            ['id' => '', 'date' => '', 'category_dependency_id' => '', 'description' => '', 'percentage_dependency' => '', 'solution' => ''],
        ];
        $this->deletedIds = [];

        $this->resetValidation();
    }

    public function submit()
    {
        $this->validate();

        try {
            // Delete removed dependencies
            if (!empty($this->deletedIds)) {
                $deletedDependencies = ActivityIssue::whereIn('id', $this->deletedIds)->get();
                if ($deletedDependencies) {
                    $deletedDependencies->each->delete();
                }
            }

            foreach ($this->dependencies as $dependency) {
                $resolved_at = null;

                if ($dependency['solution'] != '') {
                    $resolved_at = date('Y-m-d H:i:s');
                }

                if (!empty($dependency['id'])) {
                    // Update existing dependency
                    $issue = ActivityIssue::find($dependency['id'])->update([
                        'date' => $dependency['date'],
                        'category_dependency_id' => $dependency['category_dependency_id'],
                        'description' => $dependency['description'],
                        'solution' => $dependency['solution'],
                        'percentage_dependency' => $dependency['percentage_dependency'],
                        'resolved_at' => $resolved_at
                        // 'percentage_solution' => $dependency['percentage_solution'],
                    ]);
                } else {
                    // Create new dependency
                    $issue = ActivityIssue::create([
                        'activity_id' => $this->activity_id,
                        'date' => $dependency['date'],
                        'category_dependency_id' => $dependency['category_dependency_id'],
                        'description' => $dependency['description'],
                        'solution' => $dependency['solution'],
                        'percentage_dependency' => $dependency['percentage_dependency'],
                        'resolved_at' => $resolved_at
                        // 'percentage_solution' => $dependency['percentage_solution'],
                    ]);

                }
            }

            $this->alert('success', 'Dependency saved successfully');
            $this->resetForm();
            return redirect(route('activity'));
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.activity.activity-dependency-form')->layout('layouts.app', ['title' => 'Manage Dependency Activity']);
    }
}
