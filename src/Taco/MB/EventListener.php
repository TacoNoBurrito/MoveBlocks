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

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;

class EventListener implements Listener {

    /**
     * @param PlayerPreLoginEvent $event
     */
    public function onPreJoin(PlayerPreLoginEvent $event) : void {
        $player = $event->getPlayer();
        Loader::getInstance()->players[$player->getLowerCaseName()] = "";
    }

    /**
     * @param PlayerQuitEvent $event
     */
    public function onQuit(PlayerQuitEvent $event) : void {
        $player = $event->getPlayer();
        if (isset(Loader::getInstance()->players[$player->getLowerCaseName()])) unset(Loader::getInstance()->players[$player->getLowerCaseName()]);
    }

}