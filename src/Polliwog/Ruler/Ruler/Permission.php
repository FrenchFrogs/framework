<?php namespace FrenchFrogs\Polliwog\Ruler\Ruler;


trait Permission
{

    protected $permissions = [];

    /**
     * Setter for $permission container
     *
     * @param array $permissions
     * @return $this
     */
    public function setPermissions(array $permissions)
    {
        $this->permissions = $permissions;
        return $this;
    }

    /**
     * Getter
     *
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * Reset the $permissions container
     *
     * @return $this
     */
    public function clearPermissions()
    {
        $this->permissions = [];
        return $this;
    }

    /**
     * Add permission to $permission container
     *
     * @param $permission
     * @return $this
     */
    public function addPermission($permission)
    {
        $this->permissions[] = $permission;
        return $this;
    }

    /**
     * Return TRUE if the permission exist in $permission container
     *
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return array_search($permission, $this->permissions) !== false;
    }

    /**
     * Remove permission from ermission container
     *
     * @param $permission
     * @return $this
     */
    public function removePermission($permission)
    {
        if ($this->hasPermission($permission)) {
            $index =  array_search($permission, $this->permissions);
            unset($this->permissions[$index]);
        }

        return $this;
    }
}