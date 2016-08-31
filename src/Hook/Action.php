<?php
/**
 * This file is part of CaptainHook.
 *
 * (c) Sebastian Feldmann <sf@sebastian.feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CaptainHook\App\Hook;

use CaptainHook\App\Config;
use CaptainHook\App\Console\IO;
use CaptainHook\App\Git\Repository;

/**
 * Class Action
 *
 * @package CaptainHook
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/captainhook
 * @since   Class available since Release 0.9.0
 */
interface Action
{
    /**
     * Executes the action.
     *
     * @param  \CaptainHook\App\Config         $config
     * @param  \CaptainHook\App\Console\IO     $io
     * @param  \CaptainHook\App\Git\Repository $repository
     * @param  \CaptainHook\App\Config\Action  $action
     * @throws \CaptainHook\App\Exception\ActionExecution
     */
    public function execute(Config $config, IO $io, Repository $repository, Config\Action $action);
}
