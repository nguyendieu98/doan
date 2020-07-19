{{ Form::open(['url' => 'admin/store', 'method' => 'post']) }}
<div class="form-group row">
	<div class="col-md-4">
		{{Form::label('Product:')}}
		{{Form::select('product_id',$products,null,['class' => 'form-control','placeholder'=>'Select product','id'=>'product'])}}
		<span id="producterr" class="text-danger"></span>
	</div>
	<div class="col-md-2">
		{{Form::label('Size:')}}
		{{Form::select('size',array(''=>'Select size'),null,['class' => 'form-control','id'=>'size'])}}
		<span id="sizeerr" class="text-danger"></span>
	</div>
	<div class="col-md-2">
		{{Form::label('Color:')}}
		{{Form::select('color',array(''=>'Select color'),null,['class' => 'form-control','id'=>'color'])}}
		<span id="colorerr" class="text-danger"></span>
	</div>
	<div class="col-md-2">
		{{Form::label('Quantity available:')}}
		{{Form::number('quantity',0,['class' => 'form-control','min'=>'1','max'=>'10000','id'=>'quantity'])}}
		<span id="quantityerr" class="text-danger"></span>
	</div>
	<div class="col-md-2" style="margin-top: 25px;">
		{{ Form::submit('Save',['class'=>'btn btn-success','id'=>'save']) }}
	</div>
</div>
{{ Form::close() }}