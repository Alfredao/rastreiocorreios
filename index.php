<!DOCTYPE html>
<html ng-app="myApp">

<head>
    <meta charset="utf-8" />
    <title>Rastrear encomendas dos correios em tempo real</title>

    <script src="https://code.angularjs.org/1.3.15/angular.js"></script>
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" />

    <script>
    let app = angular.module('myApp', []);
    
    let params = new URLSearchParams(document.location.search.substring(1));
    let codigo = params.get('codigo');

    angular.module('myApp').controller('myController', ['$scope', '$http', '$interval', ($scope, $http, $interval) => {      
        $scope.reload = () => $http.get(`https://api.postmon.com.br/v1/rastreio/ect/${codigo}`, { cache : false }).success((data) => $scope.correios = data);
        $scope.reload();
        $interval($scope.reload, 5000);        
    }]);
</script>
</head>
<body>
    <div ng-app="myApp" ng-controller="myController">
    <h3>Pesquisando código {{correios.codigo | uppercase}}</h3>
    <table class="table table-bordered">
        <tr>
            <th>Data</th>
            <th>Local</th>
            <th>Detalhes</th>
            <th>Situação</th>
        </tr>
        <tr data-ng-repeat="historico in correios.historico">
            <td>{{historico.data}}</td>
            <td>{{historico.local}}</td>
            <td>{{historico.detalhes}}</td>
            <td>{{historico.situacao}}</td>
        </tr>    
     </table>
    </div>
<body>

</html>
