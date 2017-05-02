<?php
error_reporting( E_ALL );
/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class User extends Model
{
    
    public function __construct() 
    {
        parent::__construct();
        
        $this->table = 'users';
        
        $this->table_view['articles'] = 'author_articles';
        $this->table_view['comments'] = 'author_comments';
    }
    
    public function getAll( $only_active = false )
    {
        $sql = "SELECT * FROM $this->table";
        
        if( $only_active )
            $sql .= " AND IsActive=1";
        
        return $this->getDB()->query( $sql );
    }

    public function getByLogin( $login )
    {
        $sql = "SELECT * FROM $this->table WHERE Login = ? AND IsActive=1";
        
        $result = $this->getDB()->query( $sql, [$login] );
        
        return $result[0] ?? false;
    }
    
    public function getById( $id )
    {
        $sql = "SELECT * FROM $this->table WHERE UserId = ? AND IsActive=1";
        
        $result = $this->getDB()->query( $sql, [$id] );
        
        return $result[0] ?? false;
    }
    
    public function register( $data, $by_admin = false )
    {
        if( !isset( $data['login'] ) || !isset( $data['password'] ) || 
                !isset( $data['email'] ) )
            return false;
        
        $hashed_pw  = password_hash( $data['password'], PASSWORD_DEFAULT );
        $is_admin   = isset( $data['role'] ) ? 1 : 0;
        $is_active  = isset( $data['is_active'] ) ? 1 : 0;
        $params     = [ $data['login'], $hashed_pw, $data['email'] ];
        
        try {
            $sql = "INSERT INTO $this->table (Login,Password,Email,Role,IsActive) VALUES(?,?,?,?,?)";

            $more_params = $by_admin ? [ $is_admin, $is_active ] : 
                            [ Config::get( 'default_user_role' ), 
                              Config::get( 'default_user_status' ) ];

            $result = $this->getDB()->query( $sql, array_merge( $params, $more_params ), false );
        
            return $result;
            
        } catch ( PDOException $ex ) {
            
            echo 'Fehler: ' . $ex->getMessage();
        }
        
        return false;
    }
    
    public function update( $data, $id=null )
    {
        if( !isset( $_data['user_id'] ) || !isset( $data['role'] ) || !isset( $data['is_active'] ) )
            return false;
        
        $user_id    = ( int )$id;
        $is_admin   = isset( $data['role'] ) ? 1 : 0;
        $is_active  = isset( $_data['is_active'] ) ? 1 : 0;
        
        $sql = "UPDATE $this->table SET Role=?, IsActive=? WHERE UserId=?";
        
        $result = $this->getDB()->query( $sql, [ $is_admin, $is_active, $user_id ], false );
        
        return $result;
    }

    public function login( $login, $password ): bool
    {
        
        return $this->authenticate( $login, $password );
    }


    private function authenticate( $login, $password ): bool
    {
        
        $user = $this->getByLogin( $login );
        
        if( !$user )
            return false;
        
        return password_verify( $password, $user['Password'] );
    }
    
    public function delete( $id )
    {
        if( !$id )
            return false;
        
        $sql = "DELETE FROM $this->table WHERE UserId=?";
        
        $result = $this->getDB()->query( $sql, [$id], false );
        
        return $result;
    }
}