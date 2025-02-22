<?php

/**
 * This file is part of CaptainHook
 *
 * (c) Sebastian Feldmann <sf@sebastian.feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CaptainHook\App\Console\Command;

use Exception;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class EnableTest extends TestCase
{

    /**
     * Tests Enable::run
     *
     * @throws \Exception
     */
    public function testExecuteNoConfig(): void
    {
        $this->expectException(Exception::class);

        $output = new NullOutput();
        $input  = new ArrayInput([
            'hook'            => 'pre-commit',
            '--configuration' => 'foo',
        ]);

        $install = new Enable();
        $install->run($input, $output);
    }

    /**
     * Tests Enable::run
     *
     * @throws \Exception
     */
    public function testExecuteEnablePrePush(): void
    {
        $fakeConfig = vfsStream::setup(
            'root',
            null,
            ['captainhook.json' => file_get_contents(CH_PATH_FILES . '/config/valid.json')]
        );

        $output = new NullOutput();
        $input  = new ArrayInput([
            'hook'            => 'pre-push',
            '--configuration' => $fakeConfig->url() . '/captainhook.json',
        ]);

        $add = new Enable();
        $add->run($input, $output);

        $json = json_decode($fakeConfig->getChild('captainhook.json')->getContent(), true);
        $this->assertTrue($json['pre-push']['enabled']);
    }
}
