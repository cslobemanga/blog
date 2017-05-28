<?php
namespace Application\Models;

error_reporting( E_ALL );

use Application\Lib\Model;
use Application\Lib\Config;

/* 
 * Cart Project with MVC
 * Charles S. Lobe-Manga <charles@lobe-manga.com>  * 
 */

class User extends Model
{
    
    public function __construct() 
    {
        parent::__construct();
        
        $this->table                    = 'users';
        $this->table_view['articles']   = 'author_articles';
        $this->table_view['comments']   = 'author_comments';
    }
    
    public function getAll( bool $only_active=true )
    {
   
        $params = $only_active ? [ 'IsActive' => 1 ] : [];
        
        return parent::findAll( $this->table, $params );
    }

    public function getByLogin( string $login, bool $only_active=true )
    {
        $column     = [ 'Login' => $login ];
        $condition  = $only_active ? ['IsActive' => 1 ] : [];
        
        $result = parent::findByColumn( $this->table, $column, $condition );
        
        return $result[0] ?? false;
    }
    
    public function getById( int $id, bool $only_active=true )
    {
        $column     = [ 'UserId' => (int)$id ];
        $condition  = $only_active ? ['IsActive' => 1 ] : [];
        
        $result = parent::findByColumn( $this->table, $column, $condition );
        
        return $result[0] ?? false;
    }
    
    public function register( $data, $by_admin = false )
    {
        if( !isset( $data['login'] ) || !isset( $data['password'] ) || 
                !isset( $data['email'] ) ) {
            
            return false;
        }
        
        $login      = trim( $data['login'] );
        $hashed_pw  = password_hash( trim($data['password']), PASSWORD_DEFAULT );
        $email      = trim( $data['email'] );
        
        $is_admin   = isset( $data['role'] ) ? 1 : 0;
        $is_active  = isset( $data['is_active'] ) ? 1 : 0;
        
        if( !$by_admin ) {
            $is_admin   =  Config::get( 'default_user_role' );
            $is_active  = Config::get( 'default_user_status' );
        }
        
        $params = [ $login, $hashed_pw, $email, $is_admin, $is_active ];
        
        try {
           $columns = [ 'Login'     => $login,
                        'Password'  => $hashed_pw,
                        'Email'     => $email,
                        'Role'      => $is_admin,
                        'IsActive'  => $is_active
                      ];

            return parent::save( $columns, $this->table );
            
        } catch ( PDOException $ex ) {
            
            echo 'Fehler: ' . $ex->getMessage();
        }
        
        return false;
    }
    
    public function update( $data, $id=null )
    {
        $user_id    = ( int )$id;
        $is_admin   = isset( $data['role'] ) ? 1 : 0;
        $is_active  = isset( $data['is_active'] ) ? 1 : 0;
        
        $columns    = [ 'Role'      => $is_admin, 
                        'IsActive'  => $is_active, 
                        'UserId'    => $user_id ];
        
        return parent::save( $columns, $this->table, $user_id );
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
    
    /**
     * Deletes the user with the userid $id
     * 
     * @param int $id
     */
    public function remove( int $id )
    {
        $columns = [ 'UserId' => (int)$id ];
        
        $result = parent::delete( $columns, $this->table );
        
        return $result;
    }
}