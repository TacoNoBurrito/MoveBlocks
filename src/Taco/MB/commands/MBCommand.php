<?php namespace Taco\MB\commands;

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

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use Taco\MB\Loader;
use pocketmine\utils\TextFormat as TF;

class MBCommand extends PluginCommand {

    /**
     * MBCommand constructor.
     * @param string $name
     * @param Plugin $owner
     */
    public function __construct(string $name, Plugin $owner) {
        parent::__construct($name, $owner);
        $this->setDescription("Open the MoveBlocks Cosmetic Menu");
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool {
        if ($sender instanceof Player) {
            $sender->sendMessage(TF::GREEN."Opening Menu...");
            $menu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
            $inventory = $menu->getInventory();
            $menu->setName("MoveBlocks Cosmetics");
            foreach (Loader::getInstance()->data["blocks"] as $info1 => $info2) {
                $exploded = explode(":", $info1);
                if ($sender->hasPermission($info2["permission"])) $inventory->addItem(Item::get((int)$exploded[0], (int)$exploded[1])->setLore([TF::RESET.TF::GREEN."Tap me to make this your", "MoveBlocks cosmetic!"]));
            }
            $inventory->setItem(53, Item::get(ItemIds::RED_FLOWER)->setCustomName(TF::RESET.TF::RED."Close Menu"));
            $inventory->setItem(52, Item::get(ItemIds::RED_FLOWER)->setCustomName(TF::RESET.TF::RED."Turn Off Block Cosmetic"));
            $menu->send($sender);
            $menu->setListener(function (InvMenuTransaction $transaction) use ($sender): InvMenuTransactionResult {
                $item = $transaction->getItemClicked();
                if ($item->getCustomName() == TF::RESET.TF::RED."Close Menu") {
                    $transaction->getPlayer()->removeWindow($transaction->getAction()->getInventory());
                    return $transaction->discard();
                } else if ($item->getCustomName() == TF::RESET.TF::RED."Turn Off Block Cosmetic") {
                    Loader::getInstance()->players[$sender->getName()] = "";
                    $sender->sendMessage(TF::GREEN."Successfully turned off blocks cosmetic.");
                    $transaction->getPlayer()->removeWindow($transaction->getAction()->getInventory());
                    return $transaction->discard();
                }
                Loader::getInstance()->players[$sender->getName()] = $item->getId().":".$item->getDamage();
                $sender->sendMessage(TF::GREEN."Successfully updated MoveBlocks cosmetic.");
                $transaction->getPlayer()->removeWindow($transaction->getAction()->getInventory());
                return $transaction->discard();
            });
        }
        return true;
    }

}