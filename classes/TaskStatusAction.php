<?php
/**
 * Класс описывает все состояния задания
 * и все возможные действия с ним
 */
class TaskStatusAction
{
    private int $clientId;
    private int $doerId;
    public string $status;
    //public string $action;

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

    public function __construct(int $clientId, int $doerId, string $status)
    {
        $this->clientId = $clientId;
        $this->doerId = $doerId;
        $this->status = $status;
    }

    /**
     * @return array $status
     */
    public function getStatuses() :? array
    {
        return $this->statuses;
    }

    /**
     * @return array $actions
     */
    public function getActiones() :? array
    {
        return $this->actions;
    }

    /**
     * @return string $status
     */

    public function getActualStatus(string $action) :? string
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
     * метод определяет карту допустимых действий для заказчика
     */
     public function getAllowedAction() :? string
     {
         switch ($this->status) {
             case(self::STATUS_NEW):
                 return self::ACTION_CANCEL || self::ACTION_RESPOND;
             case(self::STATUS_WORKING):
                 return self::ACTION_FINISH || self::ACTION_REFUSE;
             case(self::STATUS_UNDO):
             case(self::STATUS_REFUSAL):
             case(self::STATUS_FINISH):
                break;
             }
         return null;
     }
}

