<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Firebase\JWT\JWT;
use Tuupola\Base62;


    // $container = $app->getContainer();
	//bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJhcmllIn0.OJ-BEAYBDij1Yx9JtCIl2jmPzhUEpIBQKIzCfhv1gSM
    // $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
    //     // Sample log message
    //     $container->get('logger')->info("Slim-Skeleton '/' route");
    //     // Render index view
    //     return $container->get('renderer')->render($response, 'index.phtml', $args);
    // });
   
    $app->get("/produk", function (Request $request, Response $response){
    	$sql = "SELECT * FROM pos_products";
    	$stmt = $this->db->prepare($sql);
    	$stmt->execute();
    	$result = $stmt->fetchAll();
    	return $response->withJson($result, 200);
    });

    $app->get("/produk/{id}", function (Request $request, Response $response, $args){
    	$id = $args["id"];
    	$sql = "SELECT * FROM pos_products WHERE productid=:id ";
    	$stmt = $this->db->prepare($sql);
    	$stmt->execute([":id" => $id]);
    	$result = $stmt->fetch();
    	return $response->withJson($result, 200);
    });
    $app->get("/produk/search/", function (Request $request, Response $response){
    	$keyword = $request->getQueryParam("keyword");
    	$sql = "SELECT * FROM pos_products WHERE productname LIKE '%$keyword%'";
    	$stmt = $this->db->prepare($sql);
    	$stmt->execute();
    	$result = $stmt->fetchAll();
    	return $response->withJson($result, 200);
    });
    $app->post("/produk", function (Request $request, Response $response){

	    $new_produk = $request->getParsedBody();

	    $sql = "INSERT INTO pos_products (productname, productstock, productstatus, productprice, productimg) VALUE (:productname, :productstock, :productstatus, :productprice, :productimg)";
	    $stmt = $this->db->prepare($sql);

	    $data = [
	        ":productname" => $new_produk["productname"], 
	        ":productstock" => $new_produk["productstock"], 
	        ":productstatus" => $new_produk["productstatus"], 
	        ":productprice" => $new_produk["productprice"], 
	        ":productimg" => $new_produk["productimg"]
	    ];

	    if($stmt->execute($data))
	       return $response->withJson(["status" => "success", "data" => "1"], 200);
	    
	    return $response->withJson(["status" => "failed", "data" => "0"], 200);
	});

    $app->put("/produk/{id}", function (Request $request, Response $response, $args){
	    $id = $args["id"];
	    $new_produk = $request->getParsedBody();
	    $sql = "UPDATE pos_products SET productname=:productname, productstock=:productstock, productstatus=:productstatus, productprice=:productprice, productimg=:productimg  WHERE productid=:productid";
	    $stmt = $this->db->prepare($sql);
	    
	    $data = [
	    	":productid" => $id,
	        ":productname" => $new_produk["productname"], 
	        ":productstock" => $new_produk["productstock"], 
	        ":productstatus" => $new_produk["productstatus"], 
	        ":productprice" => $new_produk["productprice"], 
	        ":productimg" => $new_produk["productimg"]
	    ];

	    if($stmt->execute($data))
	       return $response->withJson(["status" => "success", "data" => "1"], 200);
	    
	    return $response->withJson(["status" => "failed", "data" => "0"], 200);
	});

	$app->delete("/produk/{id}", function (Request $request, Response $response, $args){
	    $id = $args["id"];
	    $sql = "DELETE FROM pos_products WHERE productid=:productid";
	    $stmt = $this->db->prepare($sql);
	    
	    $data = [
	        ":productid" => $id
	    ];

	    if($stmt->execute($data))
	       return $response->withJson(["status" => "success", "data" => "1"], 200);
	    
	    return $response->withJson(["status" => "failed", "data" => "0"], 200);
	});

	//user
	$app->get("/user", function (Request $request, Response $response){
    	$sql = "SELECT * FROM pos_users";
    	$stmt = $this->db->prepare($sql);
    	$stmt->execute();
    	$result = $stmt->fetchAll();
    	return $response->withJson($result, 200);
    });
	 $app->get("/user/{id}", function (Request $request, Response $response, $args){
    	$id = $args["id"];
    	$sql = "SELECT * FROM pos_users WHERE userid=:id ";
    	$stmt = $this->db->prepare($sql);
    	$stmt->execute([":id" => $id]);
    	$result = $stmt->fetch();
    	return $response->withJson($result, 200);
    });
    $app->post("/user", function (Request $request, Response $response){

	    $new_user = $request->getParsedBody();

	    $sql = "INSERT INTO pos_users (email, username, userhp, password, userimg) VALUE (:email, :username, :userhp, :password, :userimg)";
	    $stmt = $this->db->prepare($sql);

	    $data = [
	        ":email" => $new_user["email"], 
	        ":username" => $new_user["username"], 
	        ":userhp" => $new_user["userhp"], 
	        ":password" => $new_user["password"], 
	        ":userimg" => $new_user["userimg"]
	    ];

	    if($stmt->execute($data))
	       return $response->withJson(["status" => "success", "data" => "1"], 200);
	    
	    return $response->withJson(["status" => "failed", "data" => "0"], 200);
	});
    $app->put("/user/{id}", function (Request $request, Response $response, $args){
	    $id = $args["id"];
	    $new_user = $request->getParsedBody();
	    $sql = "UPDATE pos_users SET email=:email, username=:username, userhp=:userhp, password=:password, userimg=:userimg WHERE userid=:userid";
	    $stmt = $this->db->prepare($sql);
	    
	    $data = [
	    	":userid" => $id,
	    	":email" => $new_user["email"], 
	        ":username" => $new_user["username"], 
	        ":userhp" => $new_user["userhp"], 
	        ":password" => $new_user["password"], 
	        ":userimg" => $new_user["userimg"]
	    ];

	    if($stmt->execute($data))
	       return $response->withJson(["status" => "success", "data" => "1"], 200);
	    
	    return $response->withJson(["status" => "failed", "data" => "0"], 200);
	});
	$app->delete("/user/{id}", function (Request $request, Response $response, $args){
	    $id = $args["id"];
	    $sql = "DELETE FROM pos_users WHERE userid=:userid";
	    $stmt = $this->db->prepare($sql);
	    
	    $data = [
	        ":userid" => $id
	    ];

	    if($stmt->execute($data))
	       return $response->withJson(["status" => "success", "data" => "1"], 200);
	    
	    return $response->withJson(["status" => "failed", "data" => "0"], 200);
	});
    
    //transaksi
    $app->get("/transaksi", function (Request $request, Response $response){
    	$sql = "SELECT * FROM pos_transaction";
    	$stmt = $this->db->prepare($sql);
    	$stmt->execute();
    	$result = $stmt->fetchAll();
    	return $response->withJson($result, 200);
    });
    $app->get("/transaksi/{id}", function (Request $request, Response $response, $args){
    	$id = $args["id"];
    	$sql = "SELECT * FROM pos_transaction WHERE transid=:id ";
    	$stmt = $this->db->prepare($sql);
    	$stmt->execute([":id" => $id]);
    	$result = $stmt->fetch();
    	return $response->withJson($result, 200);
    });
    $app->post("/transaksi", function (Request $request, Response $response){

	    $new_t = $request->getParsedBody();

	    $sql = "INSERT INTO pos_transaction (transdate, transtotal, transtotalprice, transpay, transreturn, userid, transbuyer, transnote, transstatus, transpayment) VALUE (:transdate, :transtotal, :transtotalprice, :transpay, :transreturn, :userid, :transbuyer, :transnote, :transstatus, :transpayment)";
	    $stmt = $this->db->prepare($sql);

	    $data = [
	        ":transdate" => $new_t['transdate'], 
	        ":transtotal" => $new_t['transtotal'], 
	        ":transtotalprice" => $new_t['transtotalprice'], 
	        ":transpay" => $new_t['transpay'], 
	        ":transreturn" => $new_t['transreturn'], 
	        ":userid" => $new_t['userid'], 
	        ":transbuyer" => $new_t['transbuyer'], 
	        ":transnote" => $new_t['transnote'],
	        ":transstatus" => $new_t['transstatus'],
	        ":transpayment" => $new_t['transpayment']
	    ];

	    if($stmt->execute($data))
	       return $response->withJson(["status" => "success", "data" => "1"], 200);
	    
	    return $response->withJson(["status" => "failed", "data" => "0"], 200);
	});
	$app->put("/transaksi/{id}", function (Request $request, Response $response, $args){
	    $id = $args["id"];
	    $new_t = $request->getParsedBody();
	    $sql = "UPDATE pos_transaction SET transdate=:transdate, transtotal=:transtotal, transtotalprice=:transtotalprice, transpay=:transpay, transreturn=:transreturn, userid=:userid, transbuyer=:transbuyer, transnote=:transnote, transstatus=:transstatus, transpayment=:transpayment WHERE transid=:transid";
	    $stmt = $this->db->prepare($sql);
	    
	    $data = [
	    	":transid" => $id,
	    	":transdate" => $new_t['transdate'], 
	        ":transtotal" => $new_t['transtotal'], 
	        ":transtotalprice" => $new_t['transtotalprice'], 
	        ":transpay" => $new_t['transpay'], 
	        ":transreturn" => $new_t['transreturn'], 
	        ":userid" => $new_t['userid'], 
	        ":transbuyer" => $new_t['transbuyer'], 
	        ":transnote" => $new_t['transnote'],
	        ":transstatus" => $new_t['transstatus'],
	        ":transpayment" => $new_t['transpayment']
	    ];

	    if($stmt->execute($data))
	       return $response->withJson(["status" => "success", "data" => "1"], 200);
	    
	    return $response->withJson(["status" => "failed", "data" => "0"], 200);
	});
	 $app->get("/transaksi/status/", function (Request $request, Response $response){
    	$keyword = $request->getQueryParam("keyword");
    	$sql = "SELECT * FROM pos_transaction WHERE transstatus=$keyword";
    	$stmt = $this->db->prepare($sql);
    	$stmt->execute();
    	$result = $stmt->fetchAll();
    	return $response->withJson($result, 200);
    });
	 $app->delete("/transaksi/{id}", function (Request $request, Response $response, $args){
	    $id = $args["id"];
	    $sql1 = "DELETE FROM pos_transaction WHERE transid=:transid";
	    $sql2 = "DELETE FROM pos_detail_transaction WHERE transid=:transid";
	    $stmt2 = $this->db->prepare($sql2);
	    $stmt1 = $this->db->prepare($sql1);
	    
	    $data = [
	        ":transid" => $id
	    ];

	    if(($stmt2->execute($data)) && ($stmt1->execute($data)))
	       return $response->withJson(["status" => "success", "data" => "1"], 200);
	    
	    return $response->withJson(["status" => "failed", "data" => "0"], 200);
	});

	//detailtransaksi
	$app->get("/detailtransaksi", function (Request $request, Response $response){
    	$sql = "SELECT pos_detail_transaction.*, pos_products.productname FROM pos_detail_transaction LEFT JOIN pos_products ON pos_detail_transaction.productid=pos_products.productid";
    	$stmt = $this->db->prepare($sql);
    	$stmt->execute();
    	$result = $stmt->fetchAll();
    	return $response->withJson($result, 200);
    });
    $app->get("/detailtransaksi/{id}", function (Request $request, Response $response, $args){
    	$id = $args["id"];
    	$sql = "SELECT * FROM pos_detail_transaction WHERE transid=:id ";
    	$stmt = $this->db->prepare($sql);
    	$stmt->execute([":id" => $id]);
    	$result = $stmt->fetchAll();
    	return $response->withJson($result, 200);
    });
    $app->post("/detailtransaksi", function (Request $request, Response $response){

	    $new_t = $request->getParsedBody();

	    $sql = "INSERT INTO pos_detail_transaction (transid, productid, detailnote, detailqty, detailprice) VALUE (:transid, :productid, :detailnote, :detailqty, :detailprice)";
	    $stmt = $this->db->prepare($sql);

	    $data = [
	        ":transid" => $new_t['transid'], 
	        ":productid" => $new_t['productid'], 
	        ":detailnote" => $new_t['detailnote'], 
	        ":detailqty" => $new_t['detailqty'], 
	        ":detailprice" => $new_t['detailprice']
	    ];

	    if($stmt->execute($data))
	       return $response->withJson(["status" => "success", "data" => "1"], 200);
	    
	    return $response->withJson(["status" => "failed", "data" => "0"], 200);
	});
	$app->put("/detailtransaksi/{transid}/{productid}", function (Request $request, Response $response, $args){
	    $transid = $args["transid"];
	    $productid = $args["productid"];
	    $new_t = $request->getParsedBody();
	    $sql = "UPDATE pos_detail_transaction SET detailnote=:detailnote, detailqty=:detailqty, detailprice=:detailprice WHERE transid=:transid && productid=:productid";
	    $stmt = $this->db->prepare($sql);
	    
	    $data = [
	    	":transid" => $transid,
	    	":productid" => $productid,
	    	":detailnote" => $new_t['detailnote'], 
	        ":detailqty" => $new_t['detailqty'], 
	        ":detailprice" => $new_t['detailprice']
	    ];
	    if($stmt->execute($data))
	       return $response->withJson(["status" => "success", "data" => "1"], 200);
	    
	    return $response->withJson(["status" => "failed", "data" => "0"], 200);
	});
	 $app->delete("/detailtransaksi/{tid}/{pid}", function (Request $request, Response $response, $args){
	    $tid = $args["tid"];
	    $pid = $args["pid"];
	    $sql2 = "DELETE FROM pos_detail_transaction WHERE transid=:transid && productid=:productid";
	    $stmt2 = $this->db->prepare($sql2);
	    
	    
	    $data = [
	        ":transid" => $tid,
	        ":productid" => $pid
	    ];

	    if($stmt2->execute($data))
	       return $response->withJson(["status" => "success", "data" => "1"], 200);
	    
	    return $response->withJson(["status" => "failed", "data" => "0"], 200);
	});
	 $app->get("/nilaitransaksi/", function (Request $request, Response $response){
	 	$keyword = $request->getQueryParam("keyword");
    	$sql = "SELECT SUM(transtotalprice) AS nilaitransaksi FROM pos_transaction WHERE transdate LIKE '%$keyword%'";
    	$stmt = $this->db->prepare($sql);
    	$stmt->execute();
    	$result = $stmt->fetchAll();
    	return $response->withJson($result, 200);
    });
	 $app->get("/totaltransaksi/", function (Request $request, Response $response){
	 	$keyword = $request->getQueryParam("keyword");
    	$sql = "SELECT count(transid) AS totaltransaksi FROM pos_transaction WHERE transdate LIKE '%$keyword%'";
    	$stmt = $this->db->prepare($sql);
    	$stmt->execute();
    	$result = $stmt->fetchAll();
    	return $response->withJson($result, 200);
    });
	  $app->get("/totaltransaksi", function (Request $request, Response $response){
    	$sql = "SELECT count(transid) AS totaltransaksi FROM pos_transaction";
    	$stmt = $this->db->prepare($sql);
    	$stmt->execute();
    	$result = $stmt->fetchAll();
    	return $response->withJson($result, 200);
    });
	  $app->get("/nilaitransaksi", function (Request $request, Response $response){
    	$sql = "SELECT SUM(transtotalprice) AS nilaitransaksi FROM pos_transaction";
    	$stmt = $this->db->prepare($sql);
    	$stmt->execute();
    	$result = $stmt->fetchAll();
    	return $response->withJson($result, 200);
    });


