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
                <i class="fa fa-table"></i> Crear nuevo sorteo
            </div>
            <div class="card-body">
                <form role="form" action="{{ route('sorteo.save') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Numero de cartones a generar</label>
                                <input type="number" min="1" step="1" class="form-control" name="nCartones" value="0" >
                            </div>
                        </div>
                    </div>

                    <div class="row" align="right">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-success"><i class="fa fa-fw fa-check"></i> Guardar</button> 
                        </div>
                    </div>
                </form>
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

