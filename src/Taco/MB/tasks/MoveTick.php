<?php namespace Taco\MB\tasks;

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

use pocketmine\block\Block;
use pocketmine\scheduler\Task;
use Taco\MB\Loader;

class MoveTick extends Task {

    /**
     * @param int $currentTick
     */
    public function onRun(int $currentTick) : void {
        foreach(Loader::getInstance()->getServer()->getOnlinePlayers() as $player) {
            if (!isset(Loader::getInstance()->players[$player->getName()])) return;
            $block = $player->getLevel()->getBlock($player->floor()->subtract(0, 1));
            if ($block->getId() === 0) return;
            $config = Loader::getInstance()->data;
            if (in_array($player->getLevel()->getName(), $config["banned-worlds"])) return;
            $data = Loader::getInstance()->players[$player->getName()];
            if ($data === "") return;
            $exploded = explode(":", $data);
            if ((int)$exploded[0] == $block->getId() and (int)$exploded[1] == $block->getDamage()) return;
            $player->getLevel()->setBlock($block, Block::get((int)$exploded[0], (int)$exploded[1]));
            Loader::getInstance()->getScheduler()->scheduleDelayedTask(new ReplaceTick($block), 15);
        }
    }

}