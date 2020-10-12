<?php
declare(strict_types = 1);
/**
 * /src/Command/ApiKey/ApiKeyManagementCommand.php
 */

namespace App\Command\ApiKey;

use App\Command\Traits\ExecuteMultipleCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;

/**
 * Class ApiKeyManagementCommand
 *
 * @package App\Command\ApiKey
 */
class ApiKeyManagementCommand extends Command
{
    // Traits
    use ExecuteMultipleCommand;

    /**
     * Constructor
     *
     * @throws LogicException
     *
     * @psalm-suppress InvalidScalarArgument
     */
    public function __construct()
    {
        parent::__construct('api-key:management');

        $this->setDescription('Console command to manage API keys');
        $this->setChoices([
            'api-key:list' => 'List API keys',
            'api-key:create' => 'Create API key',
            'api-key:edit' => 'Edit API key',
            'api-key:change-token' => 'Change API key token',
            'api-key:remove' => 'Remove API key',
            false => 'Exit',
        ]);
    }
}
