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
                    {{ __('Adicionar torneios') }}

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
                                <button class="nav-link" id="pills-finish-tab" data-bs-toggle="pill" data-bs-target="#pills-finish" type="button" role="tab" aria-controls="pills-finish" aria-selected="false">Finalizar</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-inicial" role="tabpanel" aria-labelledby="pills-inicial-tab">

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
                                                    name="structure[{{ $structure->id }}]['id']"
                                                >
                                                <label class="form-check-label" for="checkbox-{{ $structure->id }}">
                                                    {{ $structure->name }}
                                                </label>
                                            </div>
                                            <div class="mb-2 containerValueStructure d-none">
                                                <label for="valueStructure-{{ $structure->id }}" class="form-label">Valor</label>
                                                <input 
                                                    type="number" 
                                                    class="form-control" 
                                                    name="structure[{{ $structure->id }}]['value']"
                                                    id="valueStructure-{{ $structure->id }}"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="tab-pane fade" id="pills-finish" role="tabpanel" aria-labelledby="pills-finish-tab">
                                <div class="row mb-3">
                                    <span class="col-sm-2 col-form-label fw-bold">Nome do torneio</span>
                                    <span class="col-sm-2 col-form-label" id="review-tournament"></span>
                                </div>
                                <div class="row mb-3">
                                    <span class="col-sm-2 col-form-label fw-bold">Data do torneio</span>
                                    <span class="col-sm-2 col-form-label" id="review-date"></span>
                                </div>
                                <div class="row mb-3">
                                    <span class="col-sm-2 col-form-label fw-bold">Hora do torneio</span>
                                    <span class="col-sm-2 col-form-label" id="review-hour"></span>
                                </div>
                                <div class="row mb-3">
                                    <span class="col-sm-2 col-form-label fw-bold">Estruturas</span>
                                    <span class="col-sm-2 col-form-label" id="review-structure"></span>
                                </div>
                                <button type="submit" class="btn btn-primary">Criar torneio</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="module">
        $('#tournament').on('input', function() {
            $('#review-tournament').text($('#tournament').val());
        });

        $('#date').change(function() {
            $('#review-date').text($('#date').val());
        });

        $('#hour').change(function() {
            $('#review-hour').text($('#hour').val());
        });

        $(".form-check-input").change(function() {
            if (this.checked) {
                $(this).parent().siblings('.containerValueStructure').removeClass('d-none')
            } else {
                $(this).parent().siblings('.containerValueStructure').addClass('d-none')
            }
        });
    </script>
@endpush
