@if ($blogs->count())
    <div class="row ">
        @foreach ($blogs as $blog)
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ Storage::url($blog->image) }}" class="card-img-top" alt="{{ $blog->name }}">
                    <div class="card-body">
                        <h5 class="card-title text-center">{{ $blog->name }}</h5>
                        <p class="card-text text-center">{{ Str::limit($blog->description, 30) }}</p>
                        <div class="btn-group d-flex justify-content-center" role="group" aria-label="Basic example">
                            <button type="button" onclick="editarBlog('{{ $blog }}')" class="btn btn-primary">Ver</button>
                            &nbsp;
                            &nbsp;
                            <button type="button" onclick="eliminarBlog('{{ $blog->id }}','{{ $blog->name }}')" class="btn btn-danger">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="card-body">
        <div class="alert alert-danger mb-0" role="alert"> <span class="alert-inner--icon"><i
                    class="fe fe-slash"></i></span> <span class="alert-inner--text"><strong>Atenci&oacute;n!</strong> No
                hay registros!</span>
        </div>
    </div>
@endif
