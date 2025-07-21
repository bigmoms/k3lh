<style>
    .tree ul {
        padding-left: 1.5rem;
        list-style: none;
        position: relative;
    }

    .tree ul::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0.5rem;
        bottom: 0;
        border-left: 1px solid #ccc;
    }

    .tree li {
        position: relative;
        padding-left: 1.5rem;
        margin: 0.3rem 0;
    }

    .tree li::before {
        content: '';
        position: absolute;
        top: 0.8rem;
        left: 0;
        width: 1rem;
        height: 1px;
        border-top: 1px solid #ccc;
    }
</style>

<ul class="tree">
    @foreach ($folders as $folder)
        <li x-data="{ open: false }"> {{-- ⬅ default collapse --}}
            <div @click="open = !open" style="cursor: pointer;">
                <span x-text="open ? '📂' : '📁'"></span> {{ $folder->name }}
            </div>

            <div x-show="open" class="ml-2" x-transition>

                @if (isRoles() == 1)
                    <form action="{{ route('upload.file') }}" method="POST" enctype="multipart/form-data" class="my-2">
                        @csrf
                        <input type="hidden" name="folder_id" value="{{ $folder->id }}">

                        <div class="input-group input-group-sm mb-2" style="max-width: 400px;">
                            <input type="file" name="file" class="form-control form-control-sm"
                                accept="application/pdf" required>
                            <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                        </div>
                    </form>
                @endif


                {{-- File dalam folder --}}
                @if ($folder->files->count())
                    <ul>
                        @foreach ($folder->files as $file)
                            <li>
                                @if (isRoles() == 1)
                                    <span onclick="showPdf('{{ asset('storage/' . $file->path) }}')">
                                        📄 {{ $file->name }}
                                    </span>
                                @else
                                    <a href="javascript:void(0);" onclick="pengajuan('{{ $file->id }}')">
                                        📄 {{ $file->name }}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif

                {{-- Subfolder --}}
                @if ($folder->children->count())
                    @include('admin.folders.tree', ['folders' => $folder->children])
                @endif
            </div>
        </li>
    @endforeach
</ul>
