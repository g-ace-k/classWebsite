<?php

require_once(dirname(__FILE__) . "/../db/DatabaseFactory.class.php");
require_once(dirname(__FILE__) . "/../model/User.class.php");
require_once(dirname(__FILE__) . "/../Singleton.class.php");
require_once(dirname(__FILE__) . "/../services/PasswordFunctions.inc.php");
require_once(dirname(__FILE__) . "/BaseDao.class.php");

/**
 * @author servicetemp
 */
class UserDao extends BaseDao {

    private $columnNames = "UserID, UserName, FirstName, LastName, MiddleInitial, Email, Password, UserLevelId, StreetAddress, City, State, Zipcode, PhoneNumber";

    /**
     * 
     * @param type $userName
     * @param type $password
     * @return type
     * @throws RuntimeException
     */
    public function authenticateUser($userName, $password) {
        $query = sprintf("SELECT password FROM `user` WHERE userName='%s'", addslashes($userName));
        $pResult = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        if ($pResult->num_rows == 1) {
            $row = $pResult->fetch_row();
            $passwordHash = $row[0];
        }

        $query = sprintf("SELECT $this->columnNames FROM `user` WHERE userName='%s' and password='%s'", addslashes($userName), addslashes(getPassword($password, $passwordHash)));
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        if ($result->num_rows == 1) {
            return $this->convertRow($result->fetch_assoc());
        } else {
            throw new RuntimeException("Authentication Error");
        }
    }

    /**
     * @param type $Email
     * @param type $LastName  
     * @return $user
     * @throws RuntimeException
     */
    public function authenticateByEmail($Email, $LastName) {
        $query = sprintf("SELECT $this->columnNames "
                . "FROM `user` WHERE Email='%s' and LastName='%s'", addslashes($Email), addslashes($LastName));
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        $user = $this->convertResults($result);
        if (count($user) < 1) {
            throw new RuntimeException("No such user found");
        }
        return $user;
    }

    public function getUserByEmailAndLastName($email, $lastname) {
        $query = sprintf("SELECT $this->columnNames "
                . "FROM `user` WHERE Email = '%s' AND LastName = '%s'", addslashes($email), addslashes($lastname));
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        return $result;
    }

    /**
     * 
     * @param type $userName
     * @return $user
     */
    public function getUserByUsername($userName) {
        $query = sprintf("SELECT $this->columnNames "
                . "FROM `user` WHERE userName='%s'", addslashes($userName));
        $myResult = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        if ($myResult->num_rows == 1) {
            return $this->convertRow($myResult->fetch_assoc());
        } else {
            return false;
        }
    }

    public function changePassword($email, $password) {
        $newPassword = setPassword($password);
        $query = sprintf("UPDATE user SET password='%s' WHERE email='%s'", addslashes($newPassword), addslashes($email));
        if (DatabaseFactory::getOnePetOneVetDB()->mysql->query($query)) {
            return true;
        } else {
            throw new RuntimeException("Error Changing Password on User");
        }
    }

    /**
     * 
     * @param type $userId
     * @return type
     */
    public function getUserByUserID($userId) {
        $query = sprintf("SELECT $this->columnNames "
                . "FROM `user` WHERE userId='%s'", addslashes($userId));
        $myResult = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        $user = $this->convertRow($myResult->fetch_assoc());
        return $user;
    }

    /**
     * 
     * @return $users array
     */
    public function allUsers() {
        $query = sprintf("SELECT $this->columnNames "
                . "FROM user");
        $myResult = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        $users = $this->convertResults($myResult);
        return $users;
    }

    /**
     * 
     * @param type $row
     * @return \User
     */
    protected function convertRow($row) {
        $user = new User();
        $user->mapRow($row);
        return $user;
    }

    public function addUser($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k) {
        $query = sprintf("INSERT INTO `user` "
                . "(UserName,Password,FirstName,LastName,MiddleInitial,Email,StreetAddress,City,State,Zipcode,PhoneNumber) "
                . "VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')", addslashes($a), addslashes($b), addslashes($c), addslashes($d), addslashes($e), addslashes($f), addslashes($g), addslashes($h), addslashes($i), addslashes($j), addslashes($k));
        return DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
    }

    /**
     * 
     * @param type $userid
     * @param type $username
     * @param type $userfname
     * @param type $userlname
     * @param type $useremailaddress
     * @param type $usercity
     * @param type $userstate
     * @param type $userzip
     * @return type
     * used for excel export
     */
    public function getUserQuery($username, $userfname, $userlname, $useremailaddress, $usercity, $userstate, $userzip) {
        $columnNames = "UserID, UserName, FirstName, LastName, MiddleInitial, Email, Password, UserLevelId, StreetAddress, City, State, Zipcode, PhoneNumber";
        $query = "Select $columnNames from `user` ";
//     $query = sprintf("SELECT '%s' "
//                . "FROM `user` ", addslashes($columnNames));
        $multiple_entries = false;
        
        if ($username !== "") {

            if ($multiple_entries == false) {
                $multiple_entries = true;
                $query .= "where username ='$username' ";
            } else {
                $query .= "and username ='$username' ";
            }
        }
        if ($userfname !== "") {

            if ($multiple_entries == false) {
                $multiple_entries = true;
                $query .= "where firstname ='$userfname' ";
            } else {
                $query .= "and firstname ='$userfname' ";
            }
        }
        if ($userlname !== "") {

            if ($multiple_entries == false) {
                $multiple_entries = true;
                $query .= "where lastname ='$userlname' ";
            } else {
                $query .= "and lastname ='$userlname' ";
            }
        }

        if ($useremailaddress !== "") {

            if ($multiple_entries == false) {
                $multiple_entries = true;
                $query .= "where email ='$useremailaddress' ";
            } else {
                $query .= "and email ='$useremailaddress' ";
            }
        }if ($usercity !== "") {

            if ($multiple_entries == false) {
                $multiple_entries = true;
                $query .= "where city ='$usercity' ";
            } else {
                $query .= "and city ='$usercity' ";
            }
        }
        if ($userstate !== "") {
            if ($multiple_entries == false) {
                $multiple_entries = true;
                $query .= "where state ='$userstate' ";
            } else {
                $query .= "and state ='$userstate' ";
            }
        }
        if ($userzip !== "") {
            if ($multiple_entries == false) {
                $multiple_entries = true;
                $query .= "where zipcode =$userzip ";
            } else {
                $query .= "and zipcode =$userzip  ";
            }
        }
        return $query;
    }

    public function findUserByName($name) {
        //this is a hack due to sprintf
        $query = sprintf("SELECT $this->columnNames FROM `user` WHERE FirstName like '%s%s%s'", "%", addslashes($name), "%");
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        $users = $this->convertResults($result);
        if (count($users) < 1) {
            throw new RuntimeException("No User With That Name");
        }
        return $users;
    }

    public function findUserByFirstName($name) {
        $query = sprintf("SELECT $this->columnNames FROM `user` WHERE FirstName = '%s'", addslashes($name));
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        $users = $this->convertResults($result);
        if (count($users) < 1) {
            throw new RuntimeException("No User With That Name");
        }
        return $users;
    }
    
    public function findUserByFullName($name) {
        $names = explode(" ", $name);
        $query = sprintf("SELECT $this->columnNames FROM `user` WHERE FirstName = '%s' AND LastName = '%s'", addslashes($names[0]), addslashes($names[1]));
        $result = DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
        $users = $this->convertResults($result);
        if (count($users) < 1) {
            throw new RuntimeException("No User With That Name");
        }
        return $users;
    }

    /**
     * 
     * @param type $userId
     * @return type
     */
    public function deleteUserById($userId) {
        $query = sprintf("DELETE FROM `user` WHERE userId='%s'", addslashes($userId));
        return DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
    }

    public function updateUser($FirstName, $LastName, $MiddeInitial, $EmailAddress, $StreetAddress, $City, $State, $Zipcode, $PhoneNumber, $UpdateId) {
        $query = sprintf("UPDATE user SET FirstName = '%s', LastName = '%s', MiddleInitial = '%s', Email = '%s', StreetAddress = '%s', City = '%s', State = '%s', Zipcode = '%s', PhoneNumber = '%s' "
                . "WHERE UserID = '%s'", addslashes($FirstName), addslashes($LastName), addslashes($MiddeInitial), addslashes($EmailAddress), addslashes($StreetAddress), addslashes($City), addslashes($State), addslashes($Zipcode), addslashes($PhoneNumber), addslashes($UpdateId));
        return DatabaseFactory::getOnePetOneVetDB()->mysql->query($query);
    }

}
