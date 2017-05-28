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
    
    /**
     * Constructor, initializes the tables and inherits the database
     * instance from the parent class
     * 
     * We do need a couple of views tables to avoid too many queries
     * from the database
     */
    public function __construct() 
    {
        parent::__construct();
        
        $this->table                    = 'users';
        $this->table_view['articles']   = 'author_articles';
        $this->table_view['comments']   = 'author_comments';
    }
    
    /**
     * Returns all the records sastisfying the conditions $only_active
     * 
     * @param bool $only_active
     * @return type
     */
    public function getAll( bool $only_active=true )
    {
   
        $params = $only_active ? [ 'IsActive' => 1 ] : [];
        
        return parent::findAll( $this->table, $params );
    }

    /**
     * Returns a user given their login
     * 
     * @param string $login
     * @param bool $only_active
     * @return type
     */
    public function getByLogin( string $login, bool $only_active=true )
    {
        $column     = [ 'Login' => $login ];
        $condition  = $only_active ? ['IsActive' => 1 ] : [];
        
        $result = parent::findByColumn( $this->table, $column, $condition );
        
        return $result[0] ?? false;
    }
    
    /**
     * Returns a user given their id, is needed to fill the edit-form
     * 
     * @param int $id
     * @param bool $only_active
     * @return type
     */
    public function getById( int $id, bool $only_active=true )
    {
        $column     = [ 'UserId' => (int)$id ];
        $condition  = $only_active ? ['IsActive' => 1 ] : [];
        
        $result = parent::findByColumn( $this->table, $column, $condition );
        
        return $result[0] ?? false;
    }
    
    /**
     * Registers a new user given its form credentials.
     * 
     * From an admin point of view, values for role and status may also
     * be vorhanden.
     * 
     * @param array $data
     * @param bool $by_admin
     * @return boolean
     */
    public function register( array $data, bool $by_admin=false )
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
            $is_admin   = Config::get( 'default_user_role' );
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

            return parent::save( $this->table, $columns );
            
        } catch ( PDOException $ex ) {
            
            echo 'Fehler: ' . $ex->getMessage();
        }
        
        return false;
    }
    
    /**
     * Updates an existing user, given their new form credentials.
     * 
     * Status and role may be changed only by an admin.
     * 
     * @param array $data
     * @param string $id
     * @return type
     */
    public function update( array$data, string $id=null )
    {
        $user_id    = ( int )$id;
        $is_admin   = isset( $data['role'] ) ? 1 : 0;
        $is_active  = isset( $data['is_active'] ) ? 1 : 0;
        
        $columns    = [ 'Role'      => $is_admin, 
                        'IsActive'  => $is_active, 
                        'UserId'    => $user_id ];
        
        return parent::save( $this->table, $columns, $user_id );
    }

    /**
     * Delegates the validity check to a private function authenticate
     * 
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function login( string $login, string $password ): bool
    {
        
        return $this->authenticate( $login, $password );
    }


    /**
     * Checks the validity of the credentials
     * 
     * @param string $login
     * @param string $password
     * @return bool
     */
    private function authenticate( string $login, string $password ): bool
    {
        $user = $this->getByLogin( $login );
        
        if( !$user ) {
            return false;
        }
        
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
        
        $result = parent::delete( $this->table, $columns );
        
        return $result;
    }
}