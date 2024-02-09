@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if(session('success'))
                <x-alert type="success" :message="session('success')"/>
            @endif
            
            @if(session('error'))
                <x-alert type="error" :message="session('error')"/>
            @endif
                    
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Adicionar estruturas') }}

                    <a href="{{ route('structures.index') }}" role="button" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('structures.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="structure" class="form-label">Nome da estrutura</label>
                            <input type="text" class="form-control" id="structure" name="structure" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection