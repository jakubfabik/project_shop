<?php

namespace App\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword {

    /**
     * @Assert\Length(
     *     min = 8,
     *     minMessage = "Heslo musí mať dĺžku aspoň 8 znakov"
     * )
     */
    protected $newPassword;

    /**
     * @return mixed
     */
    public function getNewPassword() {
        return $this->newPassword;
    }

    /**
     * @param mixed $newPassword
     */
    public function setNewPassword($newPassword) {
        $this->newPassword = $newPassword;
    }


}
