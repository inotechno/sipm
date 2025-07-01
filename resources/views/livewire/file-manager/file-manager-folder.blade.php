<div class="card filemanager-sidebar me-md-2">
    <div class="card-body">

        <div class="d-flex flex-column h-100">
            <div class="mb-4">
                <div class="mb-3">
                    <div class="dropdown">
                        <button class="btn btn-light w-100" type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="mdi mdi-plus me-1"></i> Create New
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript: void(0);" wire:click="$dispatch('showModalAddFolder')"><i class="bx bx-folder me-1"></i> Folder</a>
                            <a class="dropdown-item" href="javascript: void(0);" wire:click="$dispatch('showModalAddFile')"><i class="bx bx-file me-1"></i> File</a>
                        </div>
                    </div>
                </div>
                <ul class="list-unstyled categories-list">
                    @foreach ($folders as $folder)
                        <li class="d-flex justify-content-between align-items-center">
                            <a href="javascript: void(0);" wire:click="$dispatch('loadFolderFiles', {slug: '{{ $folder->slug }}'})" class="text-body d-flex align-items-center">
                                <i class="{{ $folder->icon }} font-size-16 {{$folder->color}} me-2"></i>
                                <span class="me-auto">{{ $folder->name }} </span>
                            </a>

                            <span class="badge badge-soft-success font-size-12">{{ $folder->files->count() }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>

    @livewire('file-manager.file-manager-form-folder', key('form-folder'))
    @livewire('file-manager.file-manager-form', ['slug' => $slug], key('form-file'))

</div>
