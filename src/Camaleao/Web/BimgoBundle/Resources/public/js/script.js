var app = angular.module('myApp', []);
app.controller('productsCtrl', function($scope, $http) {
    $scope.showCreateForm = function(){
        // clear form
        $scope.clearForm();

        // change modal title
        $('#modal-product-title').text("Create New Product");

        // hide update product button
        $('#btn-update-product').hide();

        // show create product button
        $('#btn-create-product').show();

    }

    // clear variable / form values
    $scope.clearForm = function(){
        $scope.id = "";
        $scope.name = "";
        $scope.description = "";
        $scope.price = "";
    }

    // create new product
    $scope.createProduct = function(){

        // fields in key-value pairs
        $http.post('create_product.php', {
                'name' : $scope.name,
                'description' : $scope.description,
                'price' : $scope.price
            }
        ).success(function (data, status, headers, config) {
            console.log(data);
            // tell the user new product was created
            Materialize.toast(data, 4000);

            // close modal
            $('#modal-product-form').closeModal();

            // clear modal content
            $scope.clearForm();

            // refresh the list
            $scope.getAll();
        });
    }
})