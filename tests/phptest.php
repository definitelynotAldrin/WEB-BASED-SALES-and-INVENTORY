<?php
    session_start();
	include_once 'dbh.inc.php';

	if(isset($_POST['upload'])){
		$id = $_POST['id'];

        $sql = "SELECT * FROM product WHERE id = $id";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            echo "SQL statement Failed";
        }else{
            mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        
        $image = $row['images'];
        $name = $row['name'];
        
        }

        $path = "Product_images/uploads/".$image;

        $newFileName = $name;
        if(empty($newFileName)){
            $newFileName = 'image';
        }else{
            $newFileName = strtolower(str_replace("", "-", $newFileName));
        }
        
        
        
        


        $file = $_FILES['file'];
        $filename = $file["name"];
        $fileType = $file["type"];
        $fileTempName = $file["tmp_name"];
        $fileError = $file["error"];
        $fileSize = $file["size"];
        $fileExt = explode(".", $filename);
    
        $fileActualExt = strtolower(end($fileExt));
        
        $allowed = array("jpg", "jpeg", "png");
       

        if (in_array($fileActualExt, $allowed) ){
            if($fileError === 0){
                if($fileSize < 2000000){
                    $imageFullName = $newFileName . "." . uniqid("", true) . "." .$fileActualExt;
                    $fileDestination = "Product_images/uploads/" . $imageFullName;
    
                   
                    
    
                    include_once "dbh.inc.php";
     
                    if(empty($newFileName)){
                        header("Location: ../manage-items.php?upload=empty?");
                        exit();
                    }else{
                        if(!unlink($path)){
                        header("Location: ../manage-items.php?upload=Failed?");
                        exit;
                        }else{
                            
                          
                            try {
                                require_once "dbh.inc.php";
                    
                                $query = "UPDATE product SET images = :images WHERE id = $id ;";
                    
                                $stmt = $pdo->prepare($query);
                    
                                $stmt ->bindParam(":images", $imageFullName);
                                
                        
                    
                                $stmt ->execute();
                                $pdo = null;
                                $stmt = null;
                                
                                move_uploaded_file($fileTempName, $fileDestination);
                              
                    
                                header("Location: ../manage-items.php?upload=success?");

                                die();
                            } catch (PDOException $e){
                                die('QUERY FAILED: ' . $e->getMessage());
                    
                            }
                        

                
                            header("Location: ../manage-items.php?upload=success?");

                        exit;

                        }


                        
                    }
    
                }else{
                  
                    header("Location: ../manage-items.php?upload=failed&Filesize&error");
                    // echo '<script>alert("Image files is to big")</script>';
                }
            }else{
                
                header("Location: ../manage-items.php?upload=failed&You&had&an&error");
    
            }
            
        } else{
            // echo 'File format must be jpg or png';
            
            header("Location: ../manage-items.php?upload=imgfailed");
            
            exit();
        }    

	}
	else{
		$_SESSION['error'] = 'Select voter to update photo first';
	}

	header('location: ../manage-items.php');
?>