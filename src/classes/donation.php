<?php
class Donation
{
    private function __construct(
        public readonly int $id,
        public readonly float $amount,
        public readonly int $customer_id,
    ) {}

    /** Registers a new donation.
    * @param ?int $id.
    * @param ?double $amount.
    * @param ?int $customer_id.
    * @return Donation
    */
    public static function register(?int $id, ?float $amount, ?int $customer_id) : Donation
    {
        $params = array(
            ":id" => $id, 
            ":amount" => $amount, 
            ":customer_id" => $customer_id
        );
        $sth = getPDO()->prepare("INSERT INTO `donation` (`id`, `amount`, `customer_id`) VALUES (:id, :amount, :customer_id)");
        $sth->execute($params);

        return new Donation((int)getPDO()->lastInsertId(), $id, $amount, $customer_id);
    }

    public static function get(int $id) : ?Donation
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("SELECT * FROM `donation` WHERE `id` <=> :id LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new Donation($row["id"], $row["amount"], $row["customer_id"]);

        return null;
    }

    public static function getAllDonation() : ?array
    {
        $sth = getPDO()->prepare("SELECT * FROM `donation`");
        $sth->execute();
        return $sth->fetchAll();
    }

    public static function update(?int $id, ?float $amount, ?int $customer_id) : Donation
    {
        $params = array(
            ":id" => $id, 
            ":amount" => $amount, 
            ":customer_id" => $customer_id
        );
        $sth = getPDO()->prepare("UPDATE `donation` SET id = :id, amount = :amount, customer_id = :customer_id WHERE id <=> :id");
        $sth->execute($params);
        $row = $sth->fetch();

        return new Donation($row["id"], $row["amount"], $row["customer_id"]);
    }

    public function delete() : void
    {
        $params = array(":id" => $this->id);
        $sth = getPDO()->prepare("DELETE FROM `donation` WHERE :id = id");
        $sth->execute($params);
    }


}
?>