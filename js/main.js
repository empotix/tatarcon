app = angular.module('app', ['ngAnimate', 'ui.router', 'ngSanitize']);

app.service('dbrequest', function($http, $q){

	this.doDbRequest = function(urll, meth, dataa){ 
	var request = $http({method: meth, url: urll, data: dataa});
	
	return(request.then());
	}
 
});

app.service('userservices', function () {

	this.userLogin = function(name, id){
		localStorage.setItem("login", name);
		localStorage.setItem("id", id);
	}

	this.isUserLoggedIn = function(){
		if(localStorage.getItem("login") != null){
			return true;
		}else{
			return false;
		}
	}

	this.getName = function(){	
		name = localStorage.getItem("login");
		return name;
	}

	this.getId = function(){	
		id = localStorage.getItem("id");
		return id;
	}

	this.userCache = function(action, cache){
		if(action == "GET"){
			usercache = localStorage.getItem("uc");
			return JSON.parse(usercache);
		}else if(action == "SET"){
			localStorage.setItem("uc", JSON.stringify(cache));
		}
	}

	this.checkUserCache = function(){
		if(localStorage.getItem("uc") != null){
			return true;
		}else{
			return false;
		}
	}

	this.lastUser = function(action, cache){
		if(action == "GET"){
			usercache = localStorage.getItem("lc");
			return usercache;
		}else if(action == "SET"){
			localStorage.setItem("lc", cache);
		}
	}
});


app.service('chatservices', function(){
	this.chatCache = function(action, cache, withh){
		if(action == "GET"){
			usercache = localStorage.getItem(withh);
			return JSON.parse(usercache);
		}else if(action == "SET"){
			localStorage.setItem(withh, JSON.stringify(cache));
		}
	}

	this.checkChatCache = function(withh){
		if(localStorage.getItem(withh) != null){
			return true;
		}else{
			return false;
		}
	}

});



app.config(function($stateProvider, $urlRouterProvider){
	$urlRouterProvider.otherwise('/index.html')
	$stateProvider
		.state('about', {
			url: '/about',
			templateUrl: "about.html"
		})
		.state('home', {
			url: '/home',
			templateUrl: "home.html",
			controller: "homecon"
		})
		.state('profile', {
			url: '/profile/:id',
			templateUrl: "profile.html",
			controller: "profilecon"
		})
		.state('chat', {
			url: '/chat/:id',
			templateUrl: "chat.html",
			controller: "chatcon"
		})

});
app.directive('header', [function () {
	return {
		restrict: 'E',
		templateUrl: 'header.html',
		link: function (scope, iElement, iAttrs) {
			
		},
		controller: function($scope, userservices){
			$scope.loggedin = userservices.isUserLoggedIn();
			$scope.username  = userservices.getName();
		}
	};
}])


app.directive('error', [function () {
	return {
		scope: {
			errorr: "=",
			errormessage: "="
		},
		template: "<div class='alert alert-danger toggle' style='margin-top: 10px;' ng-if='errorr'>{{errormessage}}</div>",
		controller: function($scope){
		}
	};
}])

app.directive('firsttime', [function () {
	return {
		templateUrl: 'firsttime.html',
		controller: 'firsttimecon',
		link: function (scope, iElement, iAttrs) {
			
		}
	};
}])


app.controller('firsttimecon', function ($scope, userservices, dbrequest, $location) {
	
	$scope.nextstep = true;
	$scope.nextstep2 = false;
	$scope.error = false;
	$scope.errormessage = null;
	$scope.chat = false;
	$scope.firsttimeload = true;

	$scope.nextStep = function(){
		$scope.nextstep = false;
		$scope.nextstep2 = true;

	}

	$scope.joinForm = function(){
		var name = $scope.name;
			if(name == null){
				$scope.error = true;
				$scope.errormessage = "Please provide your name";
				return false;
			}

		dbrequest.doDbRequest("http://tatarcon.mzzhost.com/register.php", "POST", {name: name}).then(function(response){
			if(response.data.status == true){
				userservices.userLogin(name, response.data.id);
				$location.path("home");
			}else{
				$scope.error = true;
				$scope.errormessage = "Please try again, We are having some problems.";
				return false;
			}
		})


	}
  	
	if(userservices.isUserLoggedIn() == true){
		$scope.firsttimeload = false;
		$scope.chat = true;
		$location.path("home");
	}


});

app.controller('homecon', function($scope, $stateParams, dbrequest, userservices){
	/*if(userservices.checkUserCache() == false){*/
		dbrequest.doDbRequest("http://tatarcon.mzzhost.com/getusers.php", "GET", null).then(function(response){
			$scope.users = response.data;
			userservices.userCache("SET", response.data);
		}).then(function(){
			dbrequest.doDbRequest("http://tatarcon.mzzhost.com/getlastuser.php", "GET", null).then(function(response){
				userservices.lastUser("SET",response.data.id);
			});
		});	
	/*}else{
		dbrequest.doDbRequest("http://tatarcon.mzzhost.com/getlastuser.php", "POST", {id: userservices.lastUser("GET")}).then(function(response){
				changedValue = null;
				if(response.data.id != userservices.lastUser("GET", null)){
					changedValue = response.data.id;	
				}else{				
				$scope.users = userservices.userCache("GET", null);
				}
			}).then(function(){
				if(changedValue != null){
					dbrequest.doDbRequest("http://tatarcon.mzzhost.com/getnewusers.php", "POST", {id: userservices.lastUser("GET")}).then(function(response){
						b = response.data;
						a =  b.concat(userservices.userCache("GET", null));
						localStorage.setItem("uc", JSON.stringify(a));
						$scope.users = userservices.userCache("GET");
						userservices.lastUser("SET", changedValue);
					});
				}
			})
	}*/
	$scope.id = userservices.getId();

	$scope.clearLog = function(){
		userservices.lastUser("SET", "");
		userservices.userCache("SET", "");
	}
})


app.controller("profilecon", function($scope, $stateParams, userservices, dbrequest){
	$scope.id = $stateParams.id;
	$scope.thisUser = false;
	$scope.Showmessage = true;
	$scope.showPPchange = false;

	$scope.error = false;
	$scope.errormessage = null;

		dbrequest.doDbRequest("http://tatarcon.mzzhost.com/profile.php", "POST", {id: $scope.id}).then(function(response){
			$scope.name = response.data[0].user;
			$scope.dp = response.data[0].dp;
			$scope.id = response.data[0].id;
		});
	if(userservices.getId() == $scope.id){
		$scope.thisUser = true;
		$scope.Showmessage = false;
	} 
	$scope.changePP = function(){
		$scope.showPPchange = true;
	}


	$scope.changep = function(a){
		dbrequest.doDbRequest("http://tatarcon.mzzhost.com/changep.php", "POST", {id: $scope.id, dp: a}).then(function(response){
			if(response.data.stat == true){
				$scope.dp = a;
				$scope.showPPchange = false;
			}else{
				$scope.error = true;
				$scope.errormessage = "We are having a problem, Please try again.";
			}
		});
	}
});

app.controller('chatcon', function($scope, $stateParams, $timeout, userservices, dbrequest, chatservices){
	$scope.with = $stateParams.id;
	$scope.chatmsg = null;

	$scope.UpdateChat = function(){
		dbrequest.doDbRequest("http://tatarcon.mzzhost.com/loadallmessages.php", "POST", {to: $scope.with, id: userservices.getId()}).then(function(response){
			$scope.chatmsg = response.data;
		});
			$timeout(function(){
				$scope.UpdateChat();			
			}, 3000);
	}
	$scope.UpdateChat();




	$scope.sentMsg = function(){
		if($scope.msg == null || $scope.msg == " " || $scope.msg == ""){
			return false;
		}
		dbrequest.doDbRequest("http://tatarcon.mzzhost.com/sentmsg.php", "POST", {msg: $scope.msg, to: $scope.with, id: userservices.getId()}).then(function(response){
			//console.log(response);
		});

	}

})




