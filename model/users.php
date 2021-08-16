<?php
namespace users;

class Users extends DB
{
    // ユーザーIDからユーザー名を取得
    public function get_username_from_id($user_id)
    {
        $sql = "select user_name from users where user_id = :user_id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->execute();
        $user_name = $stmt->fetch();
        return $user_name["user_name"];
    }
}