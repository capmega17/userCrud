app.controller('UserDetailController', function($scope, $uibModal){
    $scope.user         = {};
    $scope.roles        = {};
    $scope.centers      = {};

    $scope.editDetails = function(){
        var user    = $scope.user;
        var centers = $scope.centers;
        var roles   = $scope.roles;

        var modalInstance = $uibModal.open({
            ariaLabelledBy: 'modal-title-bottom',
            ariaDescribedBy: 'modal-body-bottom',
            templateUrl: 'editDetails.html',
            controller: 'editDetailsController',
            size: 'md',
            resolve: {
                user: function(){
                  return user;
                },
                centers: function(){
                  return centers;
                },
                roles: function(){
                  return roles;
                },
                return_url: function(){
                    return 'details';
                }
            }
        });

        modalInstance.result.then(function(result){

        }, function () {

        });
    };

    $scope.updatePassword = function(){
        var user    = $scope.user;

        var modalInstance = $uibModal.open({
            ariaLabelledBy: 'modal-title-bottom',
            ariaDescribedBy: 'modal-body-bottom',
            templateUrl: 'updatePassword.html',
            controller: 'updatePasswordController',
            size: 'md',
            resolve: {
                user: function(){
                  return user;
                },
                return_url: function(){
                    return 'details';
                }
            }
        });

        modalInstance.result.then(function(result){

        }, function () {

        });
    };
});


app.controller('UserListController', function($scope, $uibModal){
    $scope.roles        = {};
    $scope.centers      = {};

    $scope.editDetails = function(user, centers, roles){
        var modalInstance = $uibModal.open({
            ariaLabelledBy: 'modal-title-bottom',
            ariaDescribedBy: 'modal-body-bottom',
            templateUrl: 'editDetails.html',
            controller: 'editDetailsController',
            size: 'md',
            resolve: {
                user: function(){
                  return user;
                },
                centers: function(){
                  return centers;
                },
                roles: function(){
                  return roles;
                },
                return_url: function(){
                    return 'list';
                }
            }
        });

        modalInstance.result.then(function(result){

        }, function () {

        });
    };

    $scope.updatePassword = function(user){
        var modalInstance = $uibModal.open({
            ariaLabelledBy: 'modal-title-bottom',
            ariaDescribedBy: 'modal-body-bottom',
            templateUrl: 'updatePassword.html',
            controller: 'updatePasswordController',
            size: 'md',
            resolve: {
                user: function(){
                  return user;
                },
                return_url: function(){
                    return 'list';
                }
            }
        });

        modalInstance.result.then(function(result){

        }, function () {

        });
    };

    /*
     * Delete a Client
     */
    $scope.deleteUser = function(user){
        var modalInstance = $uibModal.open({
            ariaLabelledBy: 'modal-title-bottom',
            ariaDescribedBy: 'modal-body-bottom',
            templateUrl: 'delete.html',
            controller: 'deleteController',
            size: 'md',
            resolve: {
                user: function(){
                  return user;
                },
                return_url: function(){
                    return 'list';
                }
            }
        });

        modalInstance.result.then(function(result){

        }, function () {

        });
    };

    $scope.activeUser = function(user){
        var modalInstance = $uibModal.open({
            ariaLabelledBy: 'modal-title-bottom',
            ariaDescribedBy: 'modal-body-bottom',
            templateUrl: 'active.html',
            controller: 'activeController',
            size: 'md',
            resolve: {
                user: function(){
                  return user;
                },
                return_url: function(){
                    return 'list';
                }
            }
        });

        modalInstance.result.then(function(result){

        }, function () {

        });
    };
});

app.controller('editDetailsController', function ($uibModalInstance, $scope, user, centers, roles, return_url){
    $scope.user     = user;
    $scope.centers  = centers;
    $scope.roles    = roles;
    $scope.action_url   = '/user/'+ user.id + '/saveDetails';
    $scope.return_url   = return_url;

    $scope.ok = function(){
        document.getElementById("detailForm").submit();
        $uibModalInstance.close();
    };

    $scope.cancel = function(){
        $uibModalInstance.dismiss('cancel');
    };
});

app.controller('updatePasswordController', function ($uibModalInstance, $scope, user, return_url){
    $scope.user     = user;
    $scope.action_url   = '/user/'+ user.id + '/updatePassword';
    $scope.return_url   = return_url;

    $scope.ok = function(){
        document.getElementById("updatePasswordForm").submit();
        $uibModalInstance.close();
    };

    $scope.cancel = function(){
        $uibModalInstance.dismiss('cancel');
    };
});

app.controller('deleteController', function ($uibModalInstance, $scope, user, return_url){
    $scope.user         = user;
    $scope.action_url   = '/user/'+ user.id + '/delete';
    $scope.return_url   = return_url;

    $scope.ok = function(){
        document.getElementById("deleteForm").submit();
        $uibModalInstance.close();
    };

    $scope.cancel = function(){
        $uibModalInstance.dismiss('cancel');
    };
});

app.controller('activeController', function ($uibModalInstance, $scope, user, return_url){
    $scope.user         = user;
    $scope.action_url   = '/user/'+ user.id + '/active';
    $scope.return_url   = return_url;

    $scope.ok = function(){
        document.getElementById("activeForm").submit();
        $uibModalInstance.close();
    };

    $scope.cancel = function(){
        $uibModalInstance.dismiss('cancel');
    };
});

