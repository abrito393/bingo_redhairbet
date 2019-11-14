@extends('welcome')

@section('name_seccion')
    Listado de Sorteos
@endsection

@section('contend')
<div class="outer">
    <div class="inner bg-container">
        <div class="inner bg-container">
    		<div class="col-lg-12">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="card m-t-35">
            <div class="card-header bg-white">
                <i class="fa fa-table"></i> Listado
            </div>
            <div class="col-lg-12" align="right"><br>
                <a href="" class="btn btn-primary btn-xs ">
                    <i class=""></i> Nuevo 
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive m-t-35">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                        <tr>
                            <th>
                                <i class="fa fa-bookmark"></i> Nombre 
                            </th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                            @foreach($data as $dat)
                                <tr>
                                    <td >
                                        {{$dat->nombre}}
                                    </td>
                                    <td>
                                        <a href="{{route('sorteoedit.edit',$dat->id)}}" class="btn btn-success btn-xs purple">
                                            <i class="fa fa-eye"></i> Editar
                                        </a>
                                        <a href="{{route('sorteodelete.delete',$dat->id)}}" class="btn btn-danger btn-xs purple">
                                            <i class="fa fa-trash"></i> Eliminar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row col-lg-12">
                {{$data->appends(Request::except('page'))->render()}}
            </div>

        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    		</div>
		</div>
	</div>
</div>
@endsection

@section('codejs')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#admin_categoria').addClass("active");
            $('#ul_admin_categoria').addClass("show");
        });
    </script>
@endsection

