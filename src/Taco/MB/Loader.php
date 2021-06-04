<?php namespace Taco\MB;

/*
  _____               _
 |_   _|_ _  ___ ___ | |
   | |/ _` |/ __/ _ \| |
   | | (_| | (_| (_) |_|
   |_|\__,_|\___\___/(_)
Copyright (C) 2021  Taco!#1305
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

use muqsit\invmenu\InvMenuHandler;
use pocketmine\plugin\PluginBase;
use Taco\MB\commands\MBCommand;
use Taco\MB\tasks\MoveTick;

class Loader extends PluginBase {

    /**
     * @var self
     */
    protected static $instance;

    /**
     * @var array
     */
    public $data = [];

    /**
     * @var array
     */
    public $players = [];

    public function onEnable() : void {
        self::$instance = $this;
        $this->saveConfig();
        $this->data = $this->getConfig()->getAll();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $this->getServer()->getCommandMap()->register("MoveBlocks", new MBCommand("mbmenu", $this));
        $this->getScheduler()->scheduleRepeatingTask(new MoveTick(), $this->data["update-time"]);
        if (!InvMenuHandler::isRegistered()) InvMenuHandler::register($this);
    }

    /**
     * @return static
     */
    public static function getInstance() : self {
        return self::$instance;
    }

}