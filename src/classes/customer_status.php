<?php
class Customer_status
{
    private function __construct(
        public readonly int $id,
        public readonly string $status,
    ) {}

    /** Registers a new customer_status.
    * @param ?int $id.
    * @param ?varchar $status.
    * @return Customer_status
    */
    public static function register(?int $id, ?string $status) : Customer_status
    {
        $params = array(
            ":id" => $id, 
            ":status" => $status
        );
        $sth = getPDO()->prepare("INSERT INTO `customer_status` (`id`, `status`) VALUES (:id, :status)");
        $sth->execute($params);

        return new Customer_status((int)getPDO()->lastInsertId(), $id, $status);
    }

    public static function get(int $id) : ?Customer_status
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("SELECT * FROM `customer_status` WHERE `id` <=> :id LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new Customer_status($row["id"], $row["status"]);

        return null;
    }

    public static function getAllCustomer_status() : ?array
    {
        $sth = getPDO()->prepare("SELECT * FROM `customer_status`");
        $sth->execute();
        return $sth->fetchAll();
    }

    public static function update(?int $id, ?string $status) : Customer_status
    {
        $params = array(
            ":id" => $id, 
            ":status" => $status
        );
        $sth = getPDO()->prepare("UPDATE `customer_status` SET id = :id, status = :status WHERE id <=> :id");
        $sth->execute($params);
        $row = $sth->fetch();

        return new Customer_status($row["id"], $row["status"]);
    }

    public function delete() : void
    {
        $params = array(":id" => $this->id);
        $sth = getPDO()->prepare("DELETE FROM `customer_status` WHERE :id = id");
        $sth->execute($params);
    }


}
?>