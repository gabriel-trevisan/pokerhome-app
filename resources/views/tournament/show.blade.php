@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if(session('success'))
            <x-alert type="success" :message="session('success')" />
            @endif

            @if(session('error'))
            <x-alert type="error" :message="session('error')" />
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Visualizar torneio') }}

                    <a href="{{ route('tournaments.index') }}" role="button" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('tournaments.store') }}">
                        @csrf
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-inicial-tab" data-bs-toggle="pill" data-bs-target="#pills-inicial" type="button" role="tab" aria-controls="pills-inicial" aria-selected="true">Inicial</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-structure-tab" data-bs-toggle="pill" data-bs-target="#pills-structure" type="button" role="tab" aria-controls="pills-structure" aria-selected="false">Estrutura</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-players-tab" data-bs-toggle="pill" data-bs-target="#pills-players" type="button" role="tab" aria-controls="pills-players" aria-selected="false">Jogadores</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-result-tab" data-bs-toggle="pill" data-bs-target="#pills-result" type="button" role="tab" aria-controls="pills-result" aria-selected="false">Resultado</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-inicial" role="tabpanel" aria-labelledby="pills-inicial-tab">

                                <div class="mb-3">
                                    <label for="tournament" class="form-label">Nome do torneio</label>
                                    <input disabled type="text" class="form-control" id="tournament" name="tournament" value="{{$tournament->name}}">
                                </div>
                                <div class="mb-3">
                                    <label for="date" class="form-label">Data do torneio</label>
                                    <input disabled type="date" class="form-control" id="date" name="date" value="{{$tournament->date}}">
                                </div>
                                <div class="mb-3">
                                    <label for="hour" class="form-label">Hora do torneio</label>
                                    <input disabled type="time" class="form-control" id="hour" name="hour" value="{{$tournament->hour}}">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-structure" role="tabpanel" aria-labelledby="pills-structure-tab">
                                @foreach ($structures as $structure)
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="form-check">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    value="{{ $structure->id }}" 
                                                    id="checkbox-{{ $structure->id }}"
                                                    name="structure[{{ $structure->id }}][id]"
                                                    checked
                                                    disabled
                                                >
                                                <label class="form-check-label" for="checkbox-{{ $structure->id }}">
                                                    {{ $structure->name }}
                                                </label>
                                            </div>
                                            <div class="mb-2 containerValueStructure">
                                                <label for="valueStructure-{{ $structure->id }}" class="form-label">Valor</label>
                                                <input 
                                                    type="number" 
                                                    class="form-control" 
                                                    name="structure[{{ $structure->id }}][value]"
                                                    id="valueStructure-{{ $structure->id }}"
                                                    value="{{$structure->value}}"
                                                    disabled
                                                >
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="tab-pane fade" id="pills-players" role="tabpanel" aria-labelledby="pills-players-tab">
                                <br>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#select-players">Selecionar jogadores</button>
                                <button type="button" class="btn btn-success">Adicionar novo jogador</button>
                            </div>
                            <div class="tab-pane fade" id="pills-result" role="tabpanel" aria-labelledby="pills-result-tab">
                                <div class="row mb-3">
                                    <span class="col-sm-2 col-form-label fw-bold">Resultado</span>
                                    <span class="col-sm-2 col-form-label" id="review-tournament">TESTE</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" class="modal fade" id="select-players" tabindex="-1" aria-labelledby="SelectPlayersLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="module">


    </script>
@endpush
