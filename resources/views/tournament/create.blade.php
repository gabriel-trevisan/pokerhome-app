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
                    {{ __('Adicionar torneios') }}

                    <a href="{{ route('tournaments.index') }}" role="button" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('tournaments.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="tournament" class="form-label">Nome do torneio</label>
                            <input type="text" class="form-control" id="tournament" name="tournament" required>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Data do torneio</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="hour" class="form-label">Hora do torneio</label>
                            <input type="time" class="form-control" id="hour" name="hour" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection