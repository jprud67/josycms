<?php
/*
 *
 * (c) Prudence D. ASSOGBA <jprud67@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 13/06/2018
 * Time: 06:44
 */

namespace Josy;


use Doctrine\ORM\EntityManager;

class DoctrineManager
{
    private $config;
    private $conn;
    public $em;

    public function __construct($conn,$config)
    {
        $this->config=$config;
        $this->conn=$conn;
        $this->em=EntityManager::create($this->conn, $this->config);
    }
}