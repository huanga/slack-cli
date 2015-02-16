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

use CL\Slack\Payload\ChannelsInfoPayload;
use CL\Slack\Payload\ChannelsInfoPayloadResponse;
use CL\Slack\Payload\PayloadResponseInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Cas Leentfaar <info@casleentfaar.com>
 */
class ChannelsInfoCommand extends AbstractApiCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('channels:info');
        $this->setDescription('Returns information about a team channel.');
        $this->addArgument('channel-id', InputArgument::REQUIRED, 'The ID of the channel to get information on');
        $this->setHelp(<<<EOT
The <info>channels:info</info> command returns information about a given channel.

For more information about the related API method, check out the official documentation:
<comment>https://api.slack.com/methods/channels.info</comment>
EOT
        );
    }

    /**
     * @param InputInterface $input
     *
     * @return ChannelsInfoPayload
     */
    protected function createPayload(InputInterface $input)
    {
        $payload = new ChannelsInfoPayload();
        $payload->setChannelId($input->getArgument('channel-id'));

        return $payload;
    }

    /**
     * {@inheritdoc}
     *
     * @param ChannelsInfoPayloadResponse $payloadResponse
     * @param InputInterface              $input
     * @param OutputInterface             $output
     */
    protected function handleResponse(PayloadResponseInterface $payloadResponse, InputInterface $input, OutputInterface $output)
    {
        if ($payloadResponse->isOk()) {
            $data = $this->serializeObjectToArray($payloadResponse->getChannel());
            $this->renderKeyValueTable($output, $data);
            $this->writeOk($output, 'Successfully retrieved information about the channel!');
        } else {
            $this->writeError($output, sprintf('Failed to retrieve information about the channel: %s', lcfirst($payloadResponse->getErrorExplanation())));
        }
    }
}