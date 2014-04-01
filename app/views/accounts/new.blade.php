@extends('layout.main')

@section('page-title')
New Account
@stop

@section('page-content')

<style>
    #content .row { padding:5px; margin-bottom:10px; border-bottom: 1px double rgba(32,32,32,0.4); }
    #content .row ul li { border-bottom:0; }
    #content .row span { display:inline-block; width: 200px; font-weight:bold; }
</style>

<div id="page-title">
	<h2>New Account</h2>
</div>

<div class="inner-page">
    <div class="row">
        <span>Name</span><input type="text" value="" required />
    </div>
    <div class="row">
        <span>Status</span>
        <select>
            <option value="active" selected>Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>
    
    
    <button>Create</button>
@stop