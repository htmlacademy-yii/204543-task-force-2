<?php

namespace TaskForce\Actions;

use TaskForce\TaskStatusAction;
use TaskForce\Actions\Action;

class ActionRefuse extends Action
{
    /**
     * получает имя действия
     * @return string
     */
    public function getActionName(): string
    {
        return 'отказаться';
    }

    /**
     * получает внутреннее имя действия
     * @return string
     */
    public function getInnerName(): string
    {
        return  TaskStatusAction::ACTION_REFUSE;
    }

    /**
     * проверяет права пользователя
     * @param int $userId
     * @param int $clientId
     * @param int $doerId
     * @param string $status
     * @return bool
     */
    public function accessRightCheck(int $userId, int $clientId, int $doerId, string $status): bool
    {
        return ($userId == $doerId && $userId !== $clientId && $status == 'working');
    }
}
