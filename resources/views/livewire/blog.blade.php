<div>
    <div class="mt-5 d-flex flex-row-reverse bd-highlight">
        <div class="p-2 bd-highlight">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newBlog">Nuevo Blog</button>
        </div>
    </div>
    <div class="card-header">
        <input type="text" wire:keydown="clear_page" wire:model="search" class="form-control w-100"
            placeholder="Escriba un nombre...">
    </div>
    @if ($blogs->count())
        <div class="row">
            @foreach ($blogs as $blog)
                <div class="col-md-4">
                    <div class="card" style="width: 18rem;">
                        <img src="{{ Storage::url($blog->image) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $blog->name }}</h5>
                            <p class="card-text">{{ Str::limit($blog->description, 30) }}</p>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary">Ver</button>
                                <button type="button" class="btn btn-danger ml-3">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card-body">
            <div class="alert alert-danger mb-0" role="alert"> <span class="alert-inner--icon"><i
                        class="fe fe-slash"></i></span> <span
                    class="alert-inner--text"><strong>Atenci&oacute;n!</strong> No hay registros!</span> </div>
        </div>
    @endif

    
    <!-- Modal -->
    <div class="modal fade" id="newBlog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Blog</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="new">
                    <div class="modal-body">
                
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
