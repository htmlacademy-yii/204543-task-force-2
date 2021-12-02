<?php
/**
 * Класс описывает все состояния задания
 * и все возможные действия с ним
 */

namespace TaskForce;

use Taskforce\Actions\Action;
use TaskForce\Actions\ActionCancel;
use TaskForce\Actions\ActionRespond;
use TaskForce\Actions\ActionFinish;
use TaskForce\Actions\ActionRefuse;

class TaskStatusAction
{
    private int $userId;
    private int $clientId;
    private int $doerId;
    private string $status;

    const CLIENT = 'client';
    const DOER = 'doer';

    const STATUS_NEW = 'new';
    const STATUS_UNDO = 'undo';
    const STATUS_WORKING = 'working';
    const STATUS_REFUSAL = 'failed';
    const STATUS_FINISH = 'finished';

    const ACTION_CREATE = 'create';
    const ACTION_CANCEL = 'cancel';
    const ACTION_RESPOND = 'respond';
    const ACTION_REFUSE = 'refuse';
    const ACTION_FINISH = 'finish';

    private array $statuses = [
                 self::STATUS_NEW => 'new',
                 self::STATUS_UNDO => 'undo',
                 self::STATUS_WORKING => 'working',
                 self::STATUS_REFUSAL => 'failed',
                 self::STATUS_FINISH => 'finished',
                ];

    private array $actions = [
                self::ACTION_CREATE => 'create',
                self::ACTION_CANCEL =>'cancel',
                self::ACTION_RESPOND => 'respond',
                self::ACTION_REFUSE => 'refuse',
                self::ACTION_FINISH => 'finish',
                ];

    public function __construct(int $userId, int $clientId, int $doerId, string $status)
    {
        $this->userId = $userId;
        $this->clientId = $clientId;
        $this->doerId = $doerId;
        $this->status = $status;
    }

    /**
     * @return array $status
     */
    public function getStatuses() : array
    {
        return $this->statuses;
    }

    /**
     * @return array $actions
     */
    public function getActiones() : array
    {
        return $this->actions;
        /*$actions = [ActCancel::class, ActRespond::class, ActDone::class, ActRefuse::class];
        $action_map = [];

        foreach ($actions as $action_key) {
            $action = $this->getAction($action_key);
            $action_map[$action->getInnerName()] = $action->getName();
        }

        return $action_map;*/
    }

    /**
     * метод получает состояние задания после выполнения определенного действия
     * @param $action
     * @return string|null
     */

    public function getActualStatus($action) :? string
    {
        switch ($action) {
    		case (self::ACTION_CREATE):
        		return self::STATUS_NEW;
        	case (self::ACTION_CANCEL):
        		return self::STATUS_UNDO;
        	case (self::ACTION_RESPOND):
        		return self::STATUS_WORKING;
        	case (self::ACTION_REFUSE):
        		return self::STATUS_REFUSAL;
        	case (self::ACTION_FINISH):
        		return self::STATUS_FINISH;
        }
        return null;
    }

    /**
     * метод определяет карту допустимых действий для пользователя в каждом из состояний задания
     * @param int $userId
     * @param int $clientId
     * @param int $doerId
     * @param string $status
     * @return string|null
     */
    public function getAllowedAction(int $userId, int $clientId, int $doerId, string $status) : string|array
    {
        $actions = [new ActionCancel(), new ActionRespond(), new ActionFinish(), new ActionRefuse];

        $allowedAction = [];

        foreach ($actions as $action)
        {
            if ($action->accessRightCheck($userId, $clientId, $doerId, $status)){
                $allowedAction = $action->getActionName();
            }
        }
        return $allowedAction;
    }
}

