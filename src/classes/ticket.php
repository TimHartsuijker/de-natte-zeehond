<?php
class Ticket
{
    private function __construct(
        public readonly int $id,
        public readonly float $price,
        public readonly string $date,
        public readonly int $customer_id,
    ) {}

    /** Registers a new ticket.
    * @param ?int $id.
    * @param ?double $price.
    * @param ?datetime $date.
    * @param ?int $customer_id.
    * @return Ticket
    */
    public static function register(?int $id, ?float $price, ?string $date, ?int $customer_id) : Ticket
    {
        $params = array(
            ":id" => $id, 
            ":price" => $price, 
            ":date" => $date, 
            ":customer_id" => $customer_id
        );
        $sth = getPDO()->prepare("INSERT INTO `ticket` (`id`, `price`, `date`, `customer_id`) VALUES (:id, :price, :date, :customer_id)");
        $sth->execute($params);

        return new Ticket((int)getPDO()->lastInsertId(), $id, $price, $date, $customer_id);
    }

    public static function get(int $id) : ?Ticket
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("SELECT * FROM `ticket` WHERE `id` <=> :id LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new Ticket($row["id"], $row["price"], $row["date"], $row["customer_id"]);

        return null;
    }

    public static function getAllTicket() : ?array
    {
        $sth = getPDO()->prepare("SELECT * FROM `ticket`");
        $sth->execute();
        return $sth->fetchAll();
    }

    public static function update(?int $id, ?float $price, ?string $date, ?int $customer_id) : Ticket
    {
        $params = array(
            ":id" => $id, 
            ":price" => $price, 
            ":date" => $date, 
            ":customer_id" => $customer_id
        );
        $sth = getPDO()->prepare("UPDATE `ticket` SET id = :id, price = :price, date = :date, customer_id = :customer_id WHERE id <=> :id");
        $sth->execute($params);
        $row = $sth->fetch();

        return new Ticket($row["id"], $row["price"], $row["date"], $row["customer_id"]);
    }

    public function delete() : void
    {
        $params = array(":id" => $this->id);
        $sth = getPDO()->prepare("DELETE FROM `ticket` WHERE :id = id");
        $sth->execute($params);
    }


}
?>