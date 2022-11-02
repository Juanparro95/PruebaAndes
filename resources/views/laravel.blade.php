<x-app-layout>
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">

                <div class="d-flex flex-row-reverse bd-highlight">
                    <div class="p-2 bd-highlight">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newBlog">Nuevo
                            Blog</button>
                    </div>
                </div>
                <div class="card-header">
                    <input type="text" onkeydown="busqueda(this.value)" wire:model="search" class="form-control w-100"
                        placeholder="Escriba un nombre...">
                </div>

                <div class="listado mt-5"></div>
                <!-- Modal -->
                <div class="modal fade" id="newBlog" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Blog</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="crear_blog">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="mb-3 row">
                                            <input type="hidden" name="id" id="id">
                                            <input type="hidden" name="image" id="image">
                                            <label for="name" class="col-sm-2 col-form-label">Nombre</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="name"
                                                    name="name">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="description" class="col-sm-2 col-form-label">Descripción</label>
                                            <div class="col-sm-10">
                                                <textarea id="description" name="description" class="form-control" rows="4" placeholder=""></textarea>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Imagen</label>
                                            <div class="col-sm-10">
                                                <div class="printImage"></div>
                                                <input type="file" class="form-control" id="file"
                                                    accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal" onclick="cancelar()">Cerrar</button>
                                    <button type="button" class="btn btn-primary btnGuardar" onclick="agregar()">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            const listado = $(".listado");
            let file = null;

            $(document).ready(function() {
                getBlog();
            })

            const getBlog = () => {
                var data = new FormData();
                data.append("_token", "{{ csrf_token() }}");
                $.ajax({
                    type: "POST",
                    data: data,
                    processData: false,
                    contentType: false,
                    url: "{{ route('get_card') }}",
                    success: function(datos) {
                        listado.html(datos.html);
                    },
                })
            }

            function busqueda(query) {
                if (query != "") {
                    var data = new FormData();
                    data.append("_token", "{{ csrf_token() }}");
                    data.append("search", query);

                    $.ajax({
                        type: "POST",
                        data: data,
                        url: "{{ route('get_card') }}",
                        processData: false,
                        contentType: false,
                        success: function(datos) {
                            listado.html(datos.html);
                        },
                    })

                    return;
                }

                getBlog();
            }

            document.getElementById("file").addEventListener("change", capturarImagen);

            function capturarImagen(event) {
                file = event.target.files[0];
            }

            function agregar() {
                if (file == null) {
                    alert("Por favor subir archivo");
                    return;
                }
                console.log(file);
                var data = new FormData();
                data.append("_token", "{{ csrf_token() }}");
                data.append("name", $("#name").val());
                data.append("description", $("#description").val());
                data.append("image", file);

                $.ajax({
                    type: "POST",
                    data: data,
                    url: "{{ route('store') }}",
                    processData: false,
                    contentType: false,
                    success: function(datos) {
                        if (datos.status == 200) {
                            Swal.fire(
                                'Correcto',
                                datos.message,
                                'success'
                            );
                            getBlog();
                            $("#newBlog").modal('hide');
                        }
                    },
                })
            }

            function editarBlog(blog){
                const jsonParse = JSON.parse(blog);
                $('#id').val(jsonParse.id);
                $('#name').val(jsonParse.name);
                $('#description').val(jsonParse.description);
                $('#image').val(jsonParse.image);
                $('.printImage').html(`<img src="{{ Storage::url("`+jsonParse.image+`") }}" class="card-img-top" />`);
                $("#newBlog").modal('show');

                $(".btnGuardar").attr("onclick", "modificar()");
                $(".btnGuardar").html("Modificar");
                $(".btnGuardar").removeClass("btnGuardar").addClass("btnModificar");
            }

            function modificar(){
                Swal.fire({
                    title: `Se modificará el POST, ¿Deseas continuar?`,
                    showDenyButton: true,
                    confirmButtonText: 'Si',
                    denyButtonText: `Aún no`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {

                        if(file == null){
                            file = $("#image").val();
                        }

                        var data = new FormData();
                        data.append("_token", "{{ csrf_token() }}");
                        data.append("id", $("#id").val());
                        data.append("name", $("#name").val());
                        data.append("description", $("#description").val());
                        data.append("image", file);
                        
                        $.ajax({
                            type: "POST",
                            data: data,
                            url: "{{ route('update') }}",
                            processData: false,
                            contentType: false,
                            success: function(datos) {
                                if (datos.status == 200) {
                                    Swal.fire(
                                        'Correcto',
                                        datos.message,
                                        'success'
                                    );
                                    $("#newBlog").modal('hide');
                                    getBlog();
                                    cancelar();
                                }
                            },
                        })
                    }
                })
            }

            function cancelar(){
                $('#id').val();
                $('#name').val();
                $('#description').val();
                $('#image').val();
                $('.printImage').html("");
                $(".btnModificar").attr("onclick", "guardar()");
                $(".btnModificar").html("Guardar");
                $(".btnModificar").removeClass("btnModificar").addClass("btnGuardar");
            }

            function eliminarBlog(idBlog, name) {
                Swal.fire({
                    title: `¿Deseas eliminar el post ${name}?`,
                    showDenyButton: true,
                    confirmButtonText: 'Si',
                    denyButtonText: `Aún no`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var data = new FormData();
                        data.append("_token", "{{ csrf_token() }}");
                        data.append("id", idBlog);
                        $.ajax({
                            type: "POST",
                            data: data,
                            url: "{{ route('destroy') }}",
                            processData: false,
                            contentType: false,
                            success: function(datos) {
                                if (datos.status == 200) {
                                    Swal.fire(
                                        'Correcto',
                                        datos.message,
                                        'success'
                                    );

                                    getBlog();
                                }
                            },
                        })
                    }
                })
            }
        </script>
    </x-slot>
</x-app-layout>
