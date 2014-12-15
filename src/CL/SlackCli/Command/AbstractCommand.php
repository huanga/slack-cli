<?php

/*
 * This file is part of the slack-cli package.
 *
 * (c) Cas Leentfaar <info@casleentfaar.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CL\SlackCli\Command;

use CL\SlackCli\Application;
use CL\SlackCli\Config\ConfigManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Cas Leentfaar <info@casleentfaar.com>
 */
abstract class AbstractCommand extends Command
{
    /**
     * @var ConfigManager|null
     */
    protected $config;

    /**
     * {@inheritdoc}
     *
     * @return Application
     */
    public function getApplication()
    {
        return parent::getApplication();
    }

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->addOption(
            'configuration-path',
            'cp',
            InputOption::VALUE_REQUIRED,
            'Configuration file to use during this command',
            ConfigManager::getDefaultPath()
        );
    }

    /**
     * @param OutputInterface $output
     * @param string          $message
     */
    protected function writeOk(OutputInterface $output, $message)
    {
        $output->writeln(sprintf('<fg=green>✔</fg=green> %s', $message));
    }

    /**
     * @param OutputInterface $output
     * @param string          $message
     */
    protected function writeComment(OutputInterface $output, $message)
    {
        $output->writeln(sprintf('<comment>%s</comment>', $message));
    }

    /**
     * @param OutputInterface $output
     * @param string          $message
     */
    protected function writeError(OutputInterface $output, $message)
    {
        $output->writeln(sprintf('<fg=red>✘</fg=red> %s', $message));
    }

    /**
     * @param OutputInterface $output
     *
     * @return Table
     */
    protected function createTable(OutputInterface $output)
    {
        $table = new Table($output);

        return $table;
    }

    /**
     * @param OutputInterface $output
     * @param array           $keysValues
     *
     * @return Table
     */
    protected function createKeyValueTable(OutputInterface $output, array $keysValues)
    {
        $table = $this->createTable($output);
        $table->setHeaders(['Key', 'Value']);
        foreach ($keysValues as $key => $value) {
            $table->addRow([$key, $value]);
        }

        return $table;
    }
}
