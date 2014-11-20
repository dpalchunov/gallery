<?php
/**
 * Created by IntelliJ IDEA.
 * User: dpalchunov
 * Date: 16/11/14
 * Time: 23:34
 * To change this template use File | Settings | File Templates.
 */

class PicClRel
{
    var $picID;
    var $cl_id;
    var $clvlID;
    var $ID;
    var $persisted;
    var $removeOnPersist;

    public function removeOnPersist()
    {
        $this->removeOnPersist = true;
    }


    /**
     * @param mixed $removeOnPersist
     */
    public function setRemoveOnPersist($removeOnPersist)
    {
        $this->removeOnPersist = $removeOnPersist;
    }

    /**
     * @return mixed
     */
    public function getRemoveOnPersist()
    {
        return $this->removeOnPersist;
    }


    /**
     * @param mixed $persisted
     */
    public function setPersisted($persisted)
    {
        $this->persisted = $persisted;
    }

    /**
     * @return mixed
     */
    public function getPersisted()
    {
        return $this->persisted;
    }

    /**
     * @param mixed $cl_id
     */
    public function setClId($cl_id)
    {
        $this->cl_id = $cl_id;
    }

    /**
     * @return mixed
     */
    public function getClId()
    {
        return $this->cl_id;
    }


    function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f = '__construct' . $i)) {
            call_user_func_array(array($this, $f), $a);
        }
    }


    public function __construct4($id, $pictureID, $cl_id, $cl_v_id)
    {
        $this->setID($id);
        $this->setPicID($pictureID);
        $this->setClvlID($cl_v_id);
        $this->setClId($cl_id);
        $this->setClId($cl_id);
        $this->setPersisted(false);
        $this->SetRemoveOnPersist(false);

    }

    /**
     * @param mixed $ID
     */
    public function setID($ID)
    {
        $this->ID = $ID;
    }

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param mixed $clvlID
     */
    public function setClvlID($clvlID)
    {
        $this->clvlID = $clvlID;
    }

    /**
     * @return mixed
     */
    public function getClvlID()
    {
        return $this->clvlID;
    }

    /**
     * @param mixed $picID
     */
    public function setPicID($picID)
    {
        $this->picID = $picID;
    }

    /**
     * @return mixed
     */
    public function getPicID()
    {
        return $this->picID;
    }

}