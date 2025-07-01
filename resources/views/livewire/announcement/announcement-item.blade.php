<div>
    <div class="card p-1 border shadow-none">
        <div class="p-3">
            <h5><a href="blog-details.html" class="text-dark">{{ $announcement->subject }}</a></h5>
            <p class="text-muted mb-0">{{ $announcement->created_at->diffForHumans() }}</p>
        </div>

        <div class="p-3">
            <ul class="list-inline">
                <li class="list-inline-item me-3">
                    <a href="javascript: void(0);" class="text-muted">
                        <i class="bx bx-user align-middle text-muted me-1"></i>
                        {{ $announcement->author->name }}
                    </a>
                </li>
                <li class="list-inline-item me-3">
                    <a href="javascript: void(0);" class="text-muted">
                        <i class="bx bx-group align-middle text-muted me-1"></i>
                        {{ $announcement->recipients->count() }} Recipients
                    </a>
                </li>
            </ul>
            <p>{{ $announcement->description_preview }}</p>

            <div>
                <a href="javascript: void(0);" class="text-primary">Read more <i class="mdi mdi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
