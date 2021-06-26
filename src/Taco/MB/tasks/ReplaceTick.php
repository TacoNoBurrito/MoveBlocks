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

class ReplaceTick extends Task {

    /**
     * @var Block
     */
    private $previous;

    /**
     * ReplaceTick constructor.
     * @param Block $previous
     */
    public function __construct(Block $previous) {
        $this->previous = $previous;
    }

    /**
     * @param int $currentTick
     */
    public function onRun(int $currentTick) : void {
        $this->previous->getLevel()->setBlock($this->previous, $this->previous);
    }

}
