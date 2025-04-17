var selectedUserCode = "";
var app = angular.module("myAngularApp", ["ngCookies"]);

app.controller(
  "adminController",
  function ($scope, $http, $cookies, $location) {
    // $scope.ui = "https://e4earning.com/admin/";
    $scope.ui = "http://16.171.47.82/dashboard/";
    $scope.loginUrl = "login.php";
    $scope.dashboardUrl = "index.php";
    $scope.dbURL =
      "http://16.171.47.82/api/";

    $scope.screenshotsURL =
      "http://16.171.47.82/uploads/deposit_screenshots/";

    $scope.username = "";

    $scope.showResponse = function (operation, msg) {
      if (operation == 1) {
        $scope.showError = false;
        $scope.showWarning = false;
        $scope.responseMsg = msg;
        $scope.showSuccess = true;
      } else if (operation == 2) {
        $scope.showSuccess = false;
        $scope.showError = false;
        $scope.responseMsg = msg;
        $scope.showWarning = true;
      } else {
        $scope.showSuccess = false;
        $scope.showWarning = false;
        $scope.responseMsg = msg;
        $scope.showError = true;
      }
    };

    $scope.login = function () {
      console.log("called")
    
      $http({
        method: "POST",
        url: $scope.dbURL + "login",
        data: {
          mobile_no: $scope.email,
          password: $scope.password,
        },
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then(function (response) {
          console.log(response.data);
          if (response.data["status"] == "success") {
            $scope.data = response.data;
            $cookies.put("token", $scope.data.token);
            $cookies.put("user", $scope.data.name);
            $cookies.put("mobile", $scope.data.mobile_no);
            $cookies.put("code", $scope.data.code);
            $cookies.put("id", $scope.data.code);

            $scope.redirect($scope.ui + $scope.dashboardUrl);
          }
          //   else {
          //     console.log("invalid Password");
          //   }
        })
        .catch(function (error) {
          console.log("This is error");
          console.log(error);
        });
    };

    $scope.fetchBids = function () {
      $http({
        method: "GET",
        url: $scope.dbURL + "fetch-hour-bids",
        data: {},
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then(function (response) {
          console.log(response.data);
          $scope.hourBids = response.data["time_wise_bids"];

          //   else {
          //     console.log("invalid Password");
          //   }
        })
        .catch(function (error) {
          console.log("This is error");
          console.log(error);
        });
    };

    $scope.usedCoins = function () {
      $http({
        method: "GET",
        url: $scope.dbURL + "git-coins?coin_type=5&type=used",
        data: {},
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then(function (response) {
          console.log(response.data);
          $scope.usedCoins = response.data["UsedCoins"];

          //   else {
          //     console.log("invalid Password");
          //   }
        })
        .catch(function (error) {
          console.log("This is error");
          console.log(error);
        });
    };

    $scope.wonCoins = function () {
      $http({
        method: "GET",
        url: $scope.dbURL + "git-coins?coin_type=3&type=won",
        data: {},
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then(function (response) {
          console.log(response.data);
          $scope.wonCoins = response.data["WonCoins"];

          //   else {
          //     console.log("invalid Password");
          //   }
        })
        .catch(function (error) {
          console.log("This is error");
          console.log(error);
        });
    };

    $scope.withdrawCoinsHistory = function () {
      $http({
        method: "GET",
        url: $scope.dbURL + "git-coins?coin_type=4&type=withdraw",
        data: {},
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then(function (response) {
          console.log(response.data);
          $scope.withdrawCoinsList = response.data["withdrawCoins"];

          //   else {
          //     console.log("invalid Password");
          //   }
        })
        .catch(function (error) {
          console.log("This is error");
          console.log(error);
        });
    };

    $scope.fetchPurchasedCoins = function () {
      $http({
        method: "GET",
        url: $scope.dbURL + "git-coins?coin_type=1&type=purchased",
        data: {},
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then(function (response) {
          console.log(response.data);
          $scope.purchasedCoins = response.data["PurchasedCoins"];
          $scope.usedCoins();
          $scope.wonCoins();
          $scope.withdrawCoinsHistory();
          //   else {
          //     console.log("invalid Password");
          //   }
        })
        .catch(function (error) {
          console.log("This is error");
          console.log(error);
        });
    };

    $scope.selectWinnerHorse = function (key, no) {
      console.log(key);
      $http({
        method: "GET",
        url:
          $scope.dbURL +
          "update-horse-id?start_time=" +
          key +
          "&winner_horse_no=" +
          no,
        data: {},
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then(function (response) {
          console.log(response.data);
          $scope.fetchBids();
          //   else {
          //     console.log("invalid Password");
          //   }
        })
        .catch(function (error) {
          console.log("This is error");
          console.log(error);
        });
    };

    $scope.balance = "0";
    $scope.userCount = "0";

    $scope.checkBalance = function () {
      $http({
        method: "GET",
        url: $scope.dbURL + "check-user-balance?userId=" + $cookies.get("id"),
        data: {},
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then(function (response) {
          console.log(response.data);
          $scope.balance = response.data["coin_balance"];

          //   else {
          //     console.log("invalid Password");
          //   }
        })
        .catch(function (error) {
          console.log("This is error");
          console.log(error);
        });
    };

    $scope.getAllUsers = function () {
      $http({
        method: "GET",
        url: $scope.dbURL + "get-users",
        data: {},
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then(function (response) {
          $scope.allUsers = response.data["users"];

          //   else {
          //     console.log("invalid Password");
          //   }
        })
        .catch(function (error) {
          console.log("This is error");
          console.log(error);
        });
    };

    $scope.usersCount = function () {
      $http({
        method: "GET",
        url: $scope.dbURL + "get-users?count=yes",
        data: {},
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then(function (response) {
          $scope.userCount = response.data["users"];

          //   else {
          //     console.log("invalid Password");
          //   }
        })
        .catch(function (error) {
          console.log("This is error");
          console.log(error);
        });
    };

    $scope.transferCoins = function () {
      if (selectedUserCode != "") {
        $http({
          method: "POST",
          url: $scope.dbURL + "available_coins",
          data: {
            from_user_code: $cookies.get("code"),
            to_user_code: selectedUserCode,
            coin_type: "1",
            coins: $scope.coins,
          },
          headers: {
            "Content-Type": "application/json",
          },
        })
          .then(function (response) {
            console.log(response.data);
            if (response.data["status"] == "Transferred") {
              $scope.showResponse(1, "Transferred");
              console.log("Transferred");
              $scope.checkBalance();
            } else {
              $scope.showResponse(3, "Insufficient Coins");
            }
          })
          .catch(function (error) {
            console.log("This is error");
            console.log(error);
          });
      } else {
        console.log("No user selected");
      }
    };

    $scope.generateCoins = function () {
      if ($scope.coinsGenerate != "" && $scope.coinsGenerate != undefined) {
        $http({
          method: "POST",
          url: $scope.dbURL + "add-admin-coins",
          data: {
            admin_id: 8,
            coins: $scope.coinsGenerate,
          },
          headers: {
            "Content-Type": "application/json",
          },
        })
          .then(function (response) {
            $scope.showResponse(1, "Coins generated");
            $scope.checkBalance();
          })
          .catch(function (error) {
            console.log("This is error");
            console.log(error);
          });
      } else {
        console.log("Enter number of coins to generate");
      }
    };

    $scope.updateAdmin = function () {
      if (
        $scope.username != "" &&
        $scope.username != undefined &&
        $scope.password != "" &&
        $scope.password != undefined
      ) {
        $http({
          method: "POST",
          url: $scope.dbURL + "reset-password-admin",
          data: {
            mobile_no: $scope.username,
            password: $scope.paassword,
          },
          headers: {
            "Content-Type": "application/json",
          },
        })
          .then(function (response) {
            // console.log(response.data);
            $scope.showResponse(1, response.data["message"]);
          })
          .catch(function (error) {
            console.log("This is error");
            alert("Error");
          });
      } else {
        alert("Enter username and password");
      }
    };

    $scope.updateAccountsJazz = function () {
      {
        $http({
          method: "POST",
          url: $scope.dbURL + "settings/JazzCash",
          data: {
            value: $scope.titleJazz + "|" + $scope.numberJazz,
            user_id: 8,
          },
          headers: {
            "Content-Type": "application/json",
          },
        })
          .then(function (response) {
            // console.log(response.data);
            $scope.showResponse(1, response.data["message"]);
          })
          .catch(function (error) {
            console.log("This is error");
            alert("error");
          });
      }
    };
    $scope.updateAccountsEasy = function () {
      {
        $http({
          method: "POST",
          url: $scope.dbURL + "settings/EasyPaisa",
          data: {
            value: $scope.titleEasy + "|" + $scope.numberEasy,
            user_id: 8,
          },
          headers: {
            "Content-Type": "application/json",
          },
        })
          .then(function (response) {
            // console.log(response.data);
            $scope.showResponse(1, response.data["message"]);
          })
          .catch(function (error) {
            console.log("This is error");
            alert("error");
          });
      }
    };

    $scope.fetchAccountsEasy = function () {
      {
        $http({
          method: "GET",
          url: $scope.dbURL + "settings/EasyPaisa?user_id=1&key=EasyPaisa",
          data: {},
          headers: {
            "Content-Type": "application/json",
          },
        })
          .then(function (response) {
            $scope.titleEasy = response.data["value"].split("|")[0];
            $scope.numberEasy = response.data["value"].split("|")[1];
            // $scope.showResponse(1, response.data["message"]);
            $scope.fetchAccountsJazz();
          })
          .catch(function (error) {
            console.log("This is error");
            // alert("error");
            console.log(error);
          });
      }
    };

    $scope.fetchAccountsJazz = function () {
      {
        $http({
          method: "GET",
          url: $scope.dbURL + "settings/JazzCash?user_id=1&key=JazzCash",
          data: {},
          headers: {
            "Content-Type": "application/json",
          },
        })
          .then(function (response) {
            $scope.titleJazz = response.data["value"].split("|")[0];
            $scope.numberJazz = response.data["value"].split("|")[1];
            // $scope.showResponse(1, response.data["message"]);
          })
          .catch(function (error) {
            console.log("This is error");
            // alert("error");
            console.log(error);
          });
      }
    };

    $scope.fetchDeposits = function () {
      {
        $http({
          method: "GET",
          url: $scope.dbURL + "deposits",
          data: {},
          headers: {
            "Content-Type": "application/json",
          },
        })
          .then(function (response) {
            console.log(response.data);
            $scope.deposits = response.data;
            // $scope.showResponse(1, response.data["message"]);
          })
          .catch(function (error) {
            console.log("This is error");
            // alert("error");
            console.log(error);
          });
      }
    };

    $scope.depositCoins = function (code, index) {
      {
        $http({
          method: "POST",
          url: $scope.dbURL + "available_coins",
          data: {
            from_user_code: $cookies.get("code"),
            to_user_code: code,
            coin_type: "1",
            coins: document.getElementsByClassName("coinsInput")[index].value,
          },
          headers: {
            "Content-Type": "application/json",
          },
        })
          .then(function (response) {
            console.log(response.data);
            if (response.data["status"] == "Transferred") {
              // $scope.showResponse(1, "Transferred");
              console.log("Transferred");
              // $scope.checkBalance();
            } else {
              $scope.showResponse(3, "Insufficient Coins");
            }
          })
          .catch(function (error) {
            console.log("This is error");
            console.log(error);
          });
      }
    };

    $scope.fetchWithdrawals = function () {
      {
        $http({
          method: "GET",
          url: $scope.dbURL + "withdraws",
          data: {},
          headers: {
            "Content-Type": "application/json",
          },
        })
          .then(function (response) {
            console.log(response.data);
            $scope.withdrawals = response.data;
            // $scope.showResponse(1, response.data["message"]);
          })
          .catch(function (error) {
            console.log("This is error");
            // alert("error");
            console.log(error);
          });
      }
    };

    $scope.withdrawCoins = function (code, index) {
      {
        $http({
          method: "POST",
          url: $scope.dbURL + "available_coins",
          data: {
            from_user_code: $cookies.get("code"),
            to_user_code: code,
            coin_type: "4",
            coins: document.getElementsByClassName("coinsInput")[index].value,
          },
          headers: {
            "Content-Type": "application/json",
          },
        })
          .then(function (response) {
            console.log(response.data);
            if (response.data["status"] == "Transferred") {
              // $scope.showResponse(1, "Transferred");
              console.log("Transferred");
              $scope.showResponse(1, "Transferred");
              // $scope.checkBalance();
            } else {
              $scope.showResponse(3, response.data["message"]);
            }
          })
          .catch(function (error) {
            console.log("This is error");
            console.log(error);
          });
      }
    };

    // Redirect Function
    $scope.redirect = function (url) {
      window.location.href = url;
    };

    // Check Token Function
    $scope.checkToken = function () {
      $scope.username = $cookies.get("user");
      $scope.url = $location.absUrl();
      $scope.token = $cookies.get("token");
      if ($scope.url.includes("login")) {
        if ($scope.token != undefined) {
          $scope.redirect($scope.ui + $scope.dashboardUrl);
        }
      } else {
        if ($scope.token == undefined) {
          $scope.redirect($scope.ui + $scope.loginUrl);
        }
      }
    };

    $scope.checkToken();

    // Logout Fucntion
    $scope.logout = function () {
      $cookies.remove("token");
      $cookies.remove("mobile");
      $cookies.remove("user");
      $cookies.remove("mobile");
      $cookies.remove("id");
      $scope.redirect($scope.ui + $scope.loginUrl);
    };

    $scope.resetBids = function () {
      {
        $http({
          method: "POST",
          url: $scope.dbURL + "remove-prev-bids",
          data: {},
          headers: {
            "Content-Type": "application/json",
          },
        })
          .then(function (response) {
            // console.log(response.data);
            alert("Bids Reset");
          })
          .catch(function (error) {
            console.log("This is error");
            console.log(error);
          });
      }
    };

    $scope.giveReward = function () {
      {
        $http({
          method: "POST",
          url: $scope.dbURL + "bid-winner",
          data: {},
          headers: {
            "Content-Type": "application/json",
          },
        })
          .then(function (response) {
            // console.log(response.data);
            alert("Rewarded");
          })
          .catch(function (error) {
            console.log("This is error");
            console.log(error);
          });
      }
    };

    // $scope.logout();
    $scope.showResponse = function (operation, msg) {
      if (operation == 1) {
        $scope.showError = false;
        $scope.showWarning = false;
        $scope.responseMsg = msg;
        $scope.showSuccess = true;
      } else if (operation == 2) {
        $scope.showSuccess = false;
        $scope.showError = false;
        $scope.responseMsg = msg;
        $scope.showWarning = true;
      } else {
        $scope.showSuccess = false;
        $scope.showWarning = false;
        $scope.responseMsg = msg;
        $scope.showError = true;
      }
    };
  }
);

function pickUser() {
  var x = document.getElementById("mySelect").value;
  selectedUserCode = x;
}

function updateWinnerHourse() {
  var x = document.getElementById("mySelectHorse").value;
  selectedHorse = x;
  console.log(x);
}
