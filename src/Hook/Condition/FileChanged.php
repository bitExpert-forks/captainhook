<?php

/**
 * This file is part of CaptainHook
 *
 * (c) Sebastian Feldmann <sf@sebastian.feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CaptainHook\App\Hook\Condition;

use CaptainHook\App\Console\IO;
use CaptainHook\App\Hook\Condition;
use SebastianFeldmann\Git\Repository;

/**
 * Class FileChange
 *
 * @package CaptainHook
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/captainhookphp/captainhook
 * @since   Class available since Release 4.2.0
 */
abstract class FileChanged implements Condition
{
    /**
     * List of file to watch
     *
     * @var string[]
     */
    protected $filesToWatch;

    /**
     * FileChange constructor
     *
     * @param string[] $files
     */
    public function __construct(array $files)
    {
        $this->filesToWatch = $files;
    }

    /**
     * Evaluates a condition
     *
     * @param  \CaptainHook\App\Console\IO       $io
     * @param  \SebastianFeldmann\Git\Repository $repository
     * @return bool
     */
    abstract public function isTrue(IO $io, Repository $repository): bool;

    /**
     * Use 'diff-tree' to find the changed files after this merge or checkout
     *
     * In case of a checkout it is easy because the arguments 'previousHead' and 'newHead' exist.
     * In case of a merge determining this hashes is more difficult so we are using the 'ref-log'
     * to do it and using 'HEAD@{1}' as the last position before the merge and 'HEAD' as the
     * current position after the merge.
     *
     * @param  \CaptainHook\App\Console\IO       $io
     * @param  \SebastianFeldmann\Git\Repository $repository
     * @return array|string[]
     */
    protected function getChangedFiles(IO $io, Repository $repository)
    {
        $oldHash = $io->getArgument('previousHead', 'HEAD@{1}');
        $newHash = $io->getArgument('newHead', 'HEAD');

        return $repository->getDiffOperator()->getChangedFiles($oldHash, $newHash);
    }
}
