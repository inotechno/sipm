<div class="w-100">
    <div class="card">
        <div class="card-body">
            <div>
                <div class="row mb-3">
                    <div class="col-xl">
                        <div class="mt-2">
                            <h5>
                                <ol class="breadcrumb">
                                    <li><a href="javascript:void(0);" wire:click="loadFolderFiles(null)">My Files</a></li>
                                    @if ($slug != null)
                                        <li><span class="mdi mdi-chevron-right"></span> {{ $folder_name }}</li>
                                    @endif
                                </ol>
                            </h5>
                        </div>
                    </div>
                    <div class="col-xl-5 col-sm-3">
                        <form class="mt-4 mt-sm-0 float-sm-end d-flex align-items-center">
                            <div class="search-box mb-2 me-2">
                                <div class="position-relative">
                                    <input type="text" class="form-control bg-light border-light rounded"
                                        placeholder="Search...">
                                    <i class="bx bx-search-alt search-icon"></i>
                                </div>
                            </div>

                            <div class="dropdown mb-0">
                                <a class="btn btn-link text-muted mt-n2" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true">
                                    <i class="mdi mdi-dots-vertical font-size-20"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Share Files</a>
                                    <a class="dropdown-item" href="#">Share with me</a>
                                    <a class="dropdown-item" href="#">Other Actions</a>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>

            <div>
                <div class="row">
                    @if (count($folders) > 0 && $slug == null)
                        @foreach ($folders as $folder)
                            <div class="col-xl-4 col-sm-6">
                                <div class="card shadow-none border">
                                    <div class="card-body p-3">
                                        <div class="">
                                            <div class="float-end ms-2">
                                                <div class="dropdown mb-2">
                                                    <a class="font-size-16 text-muted" role="button"
                                                        data-bs-toggle="dropdown" aria-haspopup="true">
                                                        <i class="mdi mdi-dots-horizontal"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="javascript:void(0);"
                                                            wire:click="loadFolderFiles('{{ $folder->slug }}')">Open</a>
                                                        <a class="dropdown-item" href="javascript:void(0);"
                                                            wire:click="$dispatch('editFolder', {folder_id: {{ $folder->id }}})">Edit</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="javascript:void(0);"
                                                            wire:click="confirmDelete({{ $folder }})">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="avatar-xs me-3 mb-3">
                                                <div class="avatar-title bg-transparent rounded">
                                                    <i
                                                        class="{{ $folder->icon }} font-size-24 {{ $folder->color }}"></i>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="overflow-hidden me-auto">
                                                    <h5 class="font-size-14 text-truncate mb-1"><a
                                                            href="javascript:void(0);"
                                                            wire:click="loadFolderFiles('{{ $folder->slug }}')"
                                                            class="text-body">{{ $folder->name }}</a></h5>
                                                    <p class="text-muted text-truncate mb-0">
                                                        {{ $folder->files->count() }} Files</p>
                                                </div>
                                                <div class="align-self-end ms-2">
                                                    <p class="text-muted mb-0">
                                                        {{ $folder->formattedSize }}
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    @else
                        @if (count($files) > 0)
                            @foreach ($files as $file)
                                <div class="col-xl-4 col-sm-6">
                                    <div class="card shadow-none border">
                                        <div class="card-body p-3">
                                            <div class="">
                                                <div class="float-end ms-2">
                                                    <div class="dropdown mb-2">
                                                        <a class="font-size-16 text-muted" role="button"
                                                            data-bs-toggle="dropdown" aria-haspopup="true">
                                                            <i class="mdi mdi-dots-horizontal"></i>
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="javascript: void(0);"
                                                                wire:click="downloadFile({{ $file }})">Download</a>
                                                            <a class="dropdown-item" href="#">Rename</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="javascript: void(0);"
                                                                wire:click="confirmRemoveFile({{ $file }})">Remove</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="avatar-xs me-3 mb-3">
                                                    <div class="avatar-title bg-transparent rounded">
                                                        <i class="{{ $file->icon }} font-size-24"></i>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="overflow-hidden me-auto">
                                                        <h5 class="font-size-14 text-truncate mb-1">
                                                            <a href="javascript: void(0);"
                                                                wire:click="downloadFile({{ $file }})"
                                                                class="text-body">{{ $file->name }}
                                                            </a>
                                                        </h5>
                                                        <p class="text-muted text-truncate mb-0">
                                                            {{ $file->ext }}</p>
                                                    </div>
                                                    <div class="align-self-end ms-2">
                                                        <p class="text-muted mb-0">
                                                            {{ $file->formattedSize }}
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md text-center">
                                <h5 class="font-size-14 text-truncate mb-1">No files found</h5>
                            </div>
                        @endif
                    @endif
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>

            {{-- <div class="mt-4">
                <div class="d-flex flex-wrap">
                    <h5 class="font-size-16 me-3">Recent Files</h5>

                    <div class="ms-auto">
                        <a href="javascript: void(0);" class="fw-medium text-reset">View All</a>
                    </div>
                </div>
                <hr class="mt-2">

                <div class="table-responsive">
                    <table class="table align-middle table-nowrap table-hover mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Date modified</th>
                                <th scope="col" colspan="2">Size</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="javascript: void(0);" class="text-dark fw-medium"><i
                                            class="mdi mdi-file-document font-size-16 align-middle text-primary me-2"></i>
                                        index.html</a></td>
                                <td>12-10-2020, 09:45</td>
                                <td>09 KB</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="font-size-16 text-muted" role="button" data-bs-toggle="dropdown"
                                            aria-haspopup="true">
                                            <i class="mdi mdi-dots-horizontal"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Open</a>
                                            <a class="dropdown-item" href="#">Edit</a>
                                            <a class="dropdown-item" href="#">Rename</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Remove</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="javascript: void(0);" class="text-dark fw-medium"><i
                                            class="mdi mdi-folder-zip font-size-16 align-middle text-warning me-2"></i>
                                        Project-A.zip</a></td>
                                <td>11-10-2020, 17:05</td>
                                <td>115 KB</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="font-size-16 text-muted" role="button" data-bs-toggle="dropdown"
                                            aria-haspopup="true">
                                            <i class="mdi mdi-dots-horizontal"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Open</a>
                                            <a class="dropdown-item" href="#">Edit</a>
                                            <a class="dropdown-item" href="#">Rename</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Remove</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="javascript: void(0);" class="text-dark fw-medium"><i
                                            class="mdi mdi-image font-size-16 align-middle text-muted me-2"></i>
                                        Img-1.jpeg</a></td>
                                <td>11-10-2020, 13:26</td>
                                <td>86 KB</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="font-size-16 text-muted" role="button" data-bs-toggle="dropdown"
                                            aria-haspopup="true">
                                            <i class="mdi mdi-dots-horizontal"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Open</a>
                                            <a class="dropdown-item" href="#">Edit</a>
                                            <a class="dropdown-item" href="#">Rename</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Remove</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="javascript: void(0);" class="text-dark fw-medium"><i
                                            class="mdi mdi-text-box font-size-16 align-middle text-muted me-2"></i>
                                        update list.txt</a></td>
                                <td>10-10-2020, 11:32</td>
                                <td>08 KB</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="font-size-16 text-muted" role="button" data-bs-toggle="dropdown"
                                            aria-haspopup="true">
                                            <i class="mdi mdi-dots-horizontal"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Open</a>
                                            <a class="dropdown-item" href="#">Edit</a>
                                            <a class="dropdown-item" href="#">Rename</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Remove</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="javascript: void(0);" class="text-dark fw-medium"><i
                                            class="mdi mdi-folder font-size-16 align-middle text-warning me-2"></i>
                                        Project B</a></td>
                                <td>10-10-2020, 10:51</td>
                                <td>72 KB</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="font-size-16 text-muted" role="button" data-bs-toggle="dropdown"
                                            aria-haspopup="true">
                                            <i class="mdi mdi-dots-horizontal"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Open</a>
                                            <a class="dropdown-item" href="#">Edit</a>
                                            <a class="dropdown-item" href="#">Rename</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Remove</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="javascript: void(0);" class="text-dark fw-medium"><i
                                            class="mdi mdi-text-box font-size-16 align-middle text-muted me-2"></i>
                                        Changes list.txt</a></td>
                                <td>09-10-2020, 17:05</td>
                                <td>07 KB</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="font-size-16 text-muted" role="button" data-bs-toggle="dropdown"
                                            aria-haspopup="true">
                                            <i class="mdi mdi-dots-horizontal"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Open</a>
                                            <a class="dropdown-item" href="#">Edit</a>
                                            <a class="dropdown-item" href="#">Rename</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Remove</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="javascript: void(0);" class="text-dark fw-medium"><i
                                            class="mdi mdi-image font-size-16 align-middle text-success me-2"></i>
                                        Img-2.png</a></td>
                                <td>09-10-2020, 15:12</td>
                                <td>31 KB</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="font-size-16 text-muted" role="button" data-bs-toggle="dropdown"
                                            aria-haspopup="true">
                                            <i class="mdi mdi-dots-horizontal"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Open</a>
                                            <a class="dropdown-item" href="#">Edit</a>
                                            <a class="dropdown-item" href="#">Rename</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Remove</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="javascript: void(0);" class="text-dark fw-medium"><i
                                            class="mdi mdi-folder font-size-16 align-middle text-warning me-2"></i>
                                        Project C</a></td>
                                <td>09-10-2020, 10:11</td>
                                <td>20 KB</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="font-size-16 text-muted" role="button" data-bs-toggle="dropdown"
                                            aria-haspopup="true">
                                            <i class="mdi mdi-dots-horizontal"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Open</a>
                                            <a class="dropdown-item" href="#">Edit</a>
                                            <a class="dropdown-item" href="#">Rename</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Remove</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="javascript: void(0);" class="text-dark fw-medium"><i
                                            class="bx bxs-file font-size-16 align-middle text-primary me-2"></i>
                                        starter-page.html</a></td>
                                <td>08-10-2020, 03:22</td>
                                <td>11 KB</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="font-size-16 text-muted" role="button" data-bs-toggle="dropdown"
                                            aria-haspopup="true">
                                            <i class="mdi mdi-dots-horizontal"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Open</a>
                                            <a class="dropdown-item" href="#">Edit</a>
                                            <a class="dropdown-item" href="#">Rename</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Remove</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> --}}
        </div>
    </div>
    <!-- end card -->

    @push('js')
        <script>
            document.addEventListener('livewire:init', function() {
                Livewire.on('change-url', event => {
                    let newUrl = event.slug ? `/files/${event.slug}` : '/files';
                    history.pushState(null, '', newUrl);
                });
            });
        </script>
    @endpush
</div>
