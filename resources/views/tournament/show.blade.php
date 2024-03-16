@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <meta name="csrf-token" content="{{ csrf_token() }}">

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
                                            <input class="form-check-input" type="checkbox" value="{{ $structure->id }}" id="checkbox-{{ $structure->id }}" name="structure[{{ $structure->id }}][id]" checked disabled>
                                            <label class="form-check-label" for="checkbox-{{ $structure->id }}">
                                                {{ $structure->name }}
                                            </label>
                                        </div>
                                        <div class="mb-2 containerValueStructure">
                                            <label for="valueStructure-{{ $structure->id }}" class="form-label">Valor</label>
                                            <input type="number" class="form-control" name="structure[{{ $structure->id }}][value]" id="valueStructure-{{ $structure->id }}" value="{{$structure->value}}" disabled>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="tab-pane fade" id="pills-players" role="tabpanel" aria-labelledby="pills-players-tab">

                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Ações
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#select-players">Selecionar jogadores para o torneio</a></li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#create-players-modal">Criar novo cadastro</a></li>
                                        <li><a class="dropdown-item" href="{{route('tournaments.transactions.index', $tournament->id)}}">Imprimir todas transações</a></li>
                                    </ul>
                                </div>

                                <br>

                                @foreach ($playersSelected as $player)
                                    <div class="card mb-2">
                                        <div class="card-body d-flex justify-content-between">
                                            <input type="hidden" value="{{ $player->id }}">
                                            <p>
                                                {{ $player->name }}
                                            </p>
                                            <button type="button" class="btn btn-primary cash-button" data-bs-toggle="modal" data-bs-target="#cash-players">Caixa</button>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <div class="tab-pane fade" id="pills-result" role="tabpanel" aria-labelledby="pills-result-tab">
                                <div class="row mb-3">
                                    <div class="row mb-3">
                                        <span class="col-sm-2 col-form-label fw-bold">Premiação total</span>
                                        <span class="col-sm-2 col-form-label" id="total-prize-pool">{{$result->total}}</span>
                                    </div>
                                    <div class="row mb-3">
                                        <span class="col-sm-2 col-form-label fw-bold">Total jogadores</span>
                                        <span class="col-sm-2 col-form-label" id="total-count-players">{{count($playersSelected)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" class="modal fade" id="create-players-modal" tabindex="-1" aria-labelledby="CreatelayersLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo cadastro jogador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="input-name-player" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="input-name-player">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="btn-form-new-player">Incluir</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" class="modal fade" id="select-players" tabindex="-1" aria-labelledby="SelectPlayersLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Selecionar jogadores para o torneio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="input-group">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control" id="search-select-player" placeholder="Pesquisar...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4>Jogadores</h4>
                    <div id="select-card-players">
                        @foreach ($playersNotSelected as $player)
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="form-check form-check-select-player">
                                        <input class="form-check-input" type="checkbox" value="{{ $player->id }}" id="checkbox-{{ $player->id }}" name="player[{{ $player->id }}][id]">
                                        <label class="form-check-label" for="checkbox-{{ $player->id }}">
                                            {{ $player->name }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="btn-select-player">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" class="modal fade" id="cash-players" tabindex="-1" aria-labelledby="CashPlayersLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Caixa Jogador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-cash-tab" data-bs-toggle="pill" data-bs-target="#pills-cash" type="button" role="tab" aria-controls="pills-cash" aria-selected="true">Caixa</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-historic-tab" data-bs-toggle="pill" data-bs-target="#pills-historic" type="button" role="tab" aria-controls="pills-historic" aria-selected="true">Histórico</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent-2">
                        <div class="tab-pane fade show active" id="pills-cash" role="tabpanel" aria-labelledby="pills-cash-tab">

                            <div class="card mb-2">
                                <div class="card-body">
                                    <input type="hidden" value="" id="cash-id-player">
                                    <p id="cash-player-name" class="fw-bold"></p>
                                </div>
                            </div>
                            <h6>Compras</h6>

                            @foreach ($structures as $structure)
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="cashStructure-{{ $structure->id }}" class="form-label">{{$structure->name}}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-outline-danger minusBtn" type="button">-</button>
                                                </div>
                                                <input type="number" class="form-control input-structure-cash" value="0" id="cashStructure-{{ $structure->id }}" name="structure-{{ $structure->id }}" disabled>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-success plusBtn" type="button">+</button>
                                                </div>
                                            </div>
                                            <div class="form-text">Informe a quantidade</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <div class="tab-pane fade" id="pills-historic" role="tabpanel" aria-labelledby="pills-historic-tab">
                            <div class="row mb-3">
                                <span class="col-sm-2 col-form-label fw-bold">Registros</span>
                                <div id="historic-player"></div>
                            </div>
                        </div>
                    </div>
                            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="btn-confirm-cash">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="module">

    $(document).ready(function(){
        $('.plusBtn').click(function(){
            let input = $(this).closest('.input-group').find('.input-structure-cash');
            let value = parseInt(input.val());
            
            if(value >= 1){
                return;
            }

            input.val(value + 1);
        });

        $('.minusBtn').click(function(){
            let input = $(this).closest('.input-group').find('.input-structure-cash');
            let value = parseInt(input.val());
            
            if(value > 0){
                input.val(value - 1);
            }
        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#btn-form-new-player").click(function(){
        let name = $("#input-name-player").val();
        let csrf = $("#input-player-csrf").val();

        if (!name) {
            alert("Digite o nome do jogador!");
            return;
        }

        $.ajax({
            method: "POST",
            url: "{{route('players.store')}}",
            data: { name: name }
        }).done(function(msg){
            alert("O jogador foi incluído com sucesso, selecione o mesmo para o torneio!: " + msg.name );
            $("#input-name-player").val("");
            location.reload();
        }).fail(function(msg){
            alert("Ocorreu um erro: " + msg.responseJSON.message);
        });
    });

    $("#btn-select-player").click(function(){
        let players = [];

        $(".form-check-select-player input").each(function() {
            if($(this).is(':checked')) {
                let id = $(this).val();

                players.push(id);
            }
        });

        if (players.length == 0) {
            alert("Selecione ao menos um jogador!");
            return;
        }

        $.ajax({
            method: "POST",
            url: "{{route('tournaments.players.store', [$tournament->id])}}",
            data: { players }
        }).done(function(msg){
            alert("Os jogadores foram adicionados com sucesso ao torneio!");
            location.reload();
        }).fail(function(msg){
            alert("Ocorreu um erro: " + msg.responseJSON.message);
        });
    });

    $(".cash-button").click(function(){
        let playerElements = this.parentNode.children;
        let inputId = playerElements[0];
        let pName = playerElements[1];

        $("#cash-id-player").val($(inputId).val());
        $("#cash-player-name").text($(pName).text());

        getHistoricTransactions();
    });

    function getHistoricTransactions() {
        let idPlayer = $("#cash-id-player").val();
        let url = "{{route('tournaments.players.transactions.store', [$tournament->id, ':idPlayer'])}}";
        let total = 0;
        
        url = url.replace(':idPlayer', idPlayer);

        $.ajax({
            method: "GET",
            url: url
        }).done(function(data){
            
            let table = '<table class="table">';
            table +=   '<thead>';
            table +=   '    <tr>';
            table +=   '       <th scope="col">#</th>';
            table +=   '       <th scope="col">Nome</th>';
            table +=   '       <th scope="col">Quantidade</th>';
            table +=   '       <th scope="col">Valor</th>';
            table +=   '    </tr>'
            table +=   '</thead>'
            table +=   '<tbody>'
            
            data.transactions.forEach(function(transaction){
                table += '<tr>';
                table +=     '<th scope="row">'+transaction.id+'</th>';
                table +=     '<td>'+transaction.name+'</td>';
                table +=     '<td>'+transaction.quantity+'</td>';
                table +=    '<td>'+transaction.value+'</td>';
                table += '</tr>';

                total += transaction.value;
            });

            table +=   '<tr>'
            table +=       '<th scope="row"></th>'
            table +=       '<td></td>'
            table +=       '<td>Total</td>'
            table +=       '<td>'+total+'</td>'
            table +=   '</tr>'

            table +=   '</tbody>';
            table += '</table>';

            $("#historic-player").html(table);
            
        }).fail(function(msg){
            alert("Ocorreu um erro ao trazer as transações!");
        });
    }

    $("#btn-confirm-cash").click(function(){
        let idPlayer = $("#cash-id-player").val();
        let transactions = [];
        let url = "{{route('tournaments.players.transactions.store', [$tournament->id, ':idPlayer'])}}";
        
        url = url.replace(':idPlayer', idPlayer);
        
        $(".input-structure-cash").each(function(){
            if ($(this).val() != 0) {
                transactions.push({
                    'id': $(this).attr('name').replace('structure-', ''),
                    'quantity': $(this).val()
                });
            }
        });

        if (transactions.length == 0) {
            alert("Digite ao menos uma estrutura!");
            return;
        }

        $.ajax({
            method: "POST",
            url: url,
            data: { transactions }
        }).done(function(msg){
            alert("Transação incluída com sucesso!");
            getHistoricTransactions();
            $('.input-structure-cash').each(function() {
                $(this).val('0');
            });
        }).fail(function(msg){
            alert("Ocorreu um erro: " + msg.responseJSON.message);
        });
    });

    $("#search-select-player").on("keyup", function() {
        var searchText = $(this).val().toLowerCase();
        $("#select-card-players .card").each(function() {
          var playerText = $(this).text().toLowerCase();
          if(playerText.indexOf(searchText) === -1) {
            $(this).hide();
          } else {
            $(this).show();
          }
        });
      });
</script>
@endpush