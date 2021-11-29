<?php

namespace TaskForce\Actions;

use TaskForce\TaskStatusAction;
use TaskForce\Actions\Action;

class ActionFinish extends Action
{
    private const INNER_NAME = 'action_finish';

    /**
     * получает имя действия
     * @return string
     */
    public function getActionName(): string
    {
        return  TaskStatusAction::ACTION_FINISH;
    }

    /**
     * получает внутреннее имя действия
     * @return string
     */
    public function getInnerName(): string
    {
        return  self::INNER_NAME;
    }

    /**
     * проверяет права пользователя
     * @param int $userId
     * @param int $clientId
     * @param int $doerId
     * @return bool
     */
    public function accessRightCheck(int $userId, int $clientId, int $doerId): bool
    {
        return ($userId == $clientId && $userId !== $doerId);
    }
}
