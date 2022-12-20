<?php
class Customer
{
    private function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $password,
        public readonly int $customer_status_id,
    ) {}

    /** Registers a new customer.
    * @param ?int $id.
    * @param ?varchar $name.
    * @param ?varchar $email.
    * @param ?varchar $phone.
    * @param ?varchar $password.
    * @param ?int $customer_status_id.
    * @return Customer
    */
    public static function register(?int $id, ?string $name, ?string $email, ?string $phone, ?string $password, ?int $customer_status_id) : Customer
    {
        $params = array(
            ":id" => $id, 
            ":name" => $name, 
            ":email" => $email, 
            ":phone" => $phone, 
            ":password" => $password, 
            ":customer_status_id" => $customer_status_id
        );
        $sth = getPDO()->prepare("INSERT INTO `customer` (`id`, `name`, `email`, `phone`, `password`, `customer_status_id`) VALUES (:id, :name, :email, :phone, :password, :customer_status_id)");
        $sth->execute($params);

        return new Customer((int)getPDO()->lastInsertId(), $id, $name, $email, $phone, $password, $customer_status_id);
    }

    public static function get(int $id) : ?Customer
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("SELECT * FROM `customer` WHERE `id` <=> :id LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new Customer($row["id"], $row["name"], $row["email"], $row["phone"], $row["password"], $row["customer_status_id"]);

        return null;
    }
    public static function login(string $email, string $password) : ?Customer
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $params = array(":email" => $email, ":password" => $password);
        $sth = getPDO()->prepare("SELECT * FROM `customer` WHERE `id` <=> :id LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new Customer($row["id"], $row["name"], $row["email"], $row["phone"], $row["password"], $row["customer_status_id"]);

        return null;
    }

    public static function getAllCustomer() : ?array
    {
        $sth = getPDO()->prepare("SELECT * FROM `customer`");
        $sth->execute();
        return $sth->fetchAll();
    }

    public static function update(?int $id, ?string $name, ?string $email, ?string $phone, ?string $password, ?int $customer_status_id) : Customer
    {
        $params = array(
            ":id" => $id, 
            ":name" => $name, 
            ":email" => $email, 
            ":phone" => $phone, 
            ":password" => $password, 
            ":customer_status_id" => $customer_status_id
        );
        $sth = getPDO()->prepare("UPDATE `customer` SET id = :id, name = :name, email = :email, phone = :phone, password = :password, customer_status_id = :customer_status_id WHERE id <=> :id");
        $sth->execute($params);
        $row = $sth->fetch();

        return new Customer($row["id"], $row["name"], $row["email"], $row["phone"], $row["password"], $row["customer_status_id"]);
    }

    public function delete() : void
    {
        $params = array(":id" => $this->id);
        $sth = getPDO()->prepare("DELETE FROM `customer` WHERE :id = id");
        $sth->execute($params);
    }


}
?>