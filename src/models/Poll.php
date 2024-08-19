<?php

namespace Ferre\Polls\Models;

use Ferre\Polls\Models\Database;

class Poll extends Database
{
    private string $uuid;
    private int $id;
    private array $options;

    public function __construct(private string $title, $createUUID = true)
    {
        parent::__construct();
        $this->options = [];

        if ($createUUID) {
            $this->uuid = uniqid();
        }

    }

    public function save(): void
    {
        $query = $this->connect()->prepare("INSERT INTO polls (uuid, title) VALUES (:uuid, :title)");
        $query->execute(["uuid" => $this->uuid, "title" => $this->title]);

        $query = $this->connect()->prepare("SELECT * FROM polls WHERE uuid = :uuid");
        $query->execute(["uuid" => $this->uuid]);

        $this->id = $query->fetchColumn();
    }

    public function insertOptions(array $options): void
    {
        foreach ($options as $option) {
            $query = $this->connect()->prepare("INSERT INTO options (poll_id, title, votes) VALUES (:poll_id, :title, 0)");
            $query->execute(["poll_id" => $this->id, "title" => $option]);

        }
    }

    public static function getPolls(): array
    {
        $polls = [];
        $db = new Database();
        $query = $db->connect()->query("SELECT * FROM polls");

        while ($r = $query->fetch()) {
            $polls[] = Poll::createFromArray($r);
        }

        return $polls;
    }

    public static function createFromArray(array $arr): Poll
    {
        $poll = new Poll($arr["title"], false);
        $poll->setUUID($arr["uuid"]);
        $poll->setId($arr["id"]);

        return $poll;
    }

    public static function find(string $uuid): Poll
    {
        $db = new Database();

        $query = $db->connect()->prepare("SELECT * FROM polls WHERE uuid = :uuid");
        $query->execute(["uuid" => $uuid]);
        $result = $query->fetch();

        $poll = Poll::createFromArray($result);

        //consulta de opciones
        $query = $db->connect()->prepare("SELECT * FROM polls INNER JOIN options ON polls.id = options.poll_id WHERE polls.uuid = :uuid");
        $query->execute(["uuid" => $uuid]);

        while ($r = $query->fetch()) {
            $poll->includeOption($r);
        }

        return $poll;
    }

    public function vote($optionId): Poll
    {
        $query = $this->connect()->prepare("UPDATE options SET votes = votes + 1 WHERE id = :id");
        $query->execute(["id" => $optionId]);

        $poll = Poll::find($this->uuid);

        return $poll;
    }

    public function getTotalVotes(): int
    {
        $total = 0;

        foreach($this->options as $option){
            $total += $option["votes"];
        }

        return $total;
    }

    public function includeOption($option): void
    {
        $this->options[] = $option;
    }

    public function setUUID(string $value): void
    {
        $this->uuid = $value;
    }

    public function setId(int $value): void
    {
        $this->id = $value;
    }

}
