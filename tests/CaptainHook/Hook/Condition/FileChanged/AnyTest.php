<?php

/**
 * This file is part of CaptainHook
 *
 * (c) Sebastian Feldmann <sf@sebastian.feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CaptainHook\App\Hook\Condition\FileChanged;

use CaptainHook\App\Console\IO\Mockery as IOMockery;
use CaptainHook\App\Mockery as CHMockery;
use PHPUnit\Framework\TestCase;

/**
 * Class All
 *
 * The FileChange condition is applicable for `post-merge` and `post-checkout` hooks.
 * It makes sure all configured files are updated before executing the action.
 *
 * @package CaptainHook
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/captainhookphp/captainhook
 * @since   Class available since Release 4.2.0
 */
class AnyTest extends TestCase
{
    use IOMockery;
    use CHMockery;

    /**
     * Tests Any::isTrue
     */
    public function testIsTrue(): void
    {
        $io = $this->createIOMock();
        $io->expects($this->exactly(2))->method('getArgument')->willReturn('');
        $operator   = $this->createGitDiffOperator(['fiz.php', 'baz.php', 'foo.php']);
        $repository = $this->createRepositoryMock('');
        $repository->expects($this->once())->method('getDiffOperator')->willReturn($operator);

        $fileChange = new Any(['foo.php', 'bar.php']);

        $this->assertTrue($fileChange->isTrue($io, $repository));
    }

    /**
     * Tests Any::isTrue
     */
    public function testIsFalse(): void
    {
        $io = $this->createIOMock();
        $io->expects($this->exactly(2))->method('getArgument')->willReturn('');
        $operator   = $this->createGitDiffOperator(['fiz.php', 'baz.php']);
        $repository = $this->createRepositoryMock('');
        $repository->expects($this->once())->method('getDiffOperator')->willReturn($operator);

        $fileChange = new Any(['foo.php', 'bar.php']);

        $this->assertFalse($fileChange->isTrue($io, $repository));
    }
}
