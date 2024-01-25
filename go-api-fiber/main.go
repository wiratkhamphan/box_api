package main

import (
	"database/sql"
	"fmt"
	"log"

	_ "github.com/go-sql-driver/mysql"
	"github.com/gofiber/fiber/v2"
	"github.com/gofiber/fiber/v2/middleware/cors"
)

type Box struct {
	ID      int    `json:"ID"`
	Appress string `json:"Appress"`
	Box     string `json:"Box"`
}

func CommDB() (*sql.DB, error) {
	dbDriver := "mysql"
	dbUser := "root"
	dbPass := ""
	dbName := "shoplek"
	db, err := sql.Open(dbDriver, fmt.Sprintf("%s:%s@/%s", dbUser, dbPass, dbName))
	if err != nil {
		log.Fatal(err)
		return nil, fmt.Errorf("error opening database connection: %w", err)
	}

	// Perform a Ping to check if the database connection is valid
	if err := db.Ping(); err != nil {
		db.Close() // Close the connection if Ping fails
		return nil, fmt.Errorf("error pinging database: %w", err)
	}

	return db, nil
}

func GetBox(c *fiber.Ctx) error {
	db, err := CommDB()
	if err != nil {
		log.Println("Error connecting to the database:", err)
		return fiber.ErrInternalServerError
	}
	rows, err := db.Query("SELECT * FROM box")
	if err != nil {
		log.Println("Error executing SELECT query:", err)
		return fiber.ErrInternalServerError
	}
	var boxes []Box

	for rows.Next() {
		var box Box

		if err := rows.Scan(&box.ID, &box.Box, &box.Appress); err != nil {
			log.Println("Error scanning row values:", err)
			return fiber.ErrInternalServerError
		}
		boxes = append(boxes, box)
	}

	return c.JSON(boxes)
}

func GetBoxID(c *fiber.Ctx) error {
	BOX_ID, err := c.ParamsInt("BOX_ID")
	if err != nil {
		return fiber.ErrBadRequest
	}

	db, err := CommDB()
	if err != nil {
		log.Println("Error connecting to the database:", err)
		return fiber.ErrInternalServerError
	}
	// defer db.Close()

	// Execute a query to fetch data from the 'box' table based on the provided ID
	row := db.QueryRow("SELECT * FROM box WHERE id = ?", BOX_ID)
	var box Box

	// Scan the result into the 'box' struct
	if err = row.Scan(&box.ID, &box.Box, &box.Appress); err != nil {
		return err
	}

	return c.JSON(box)
}

func main() {
	app := fiber.New()
	app.Use(cors.New())

	app.Get("/Box", GetBox)
	app.Get("/Box/:BOX_ID", GetBoxID)

	app.Listen(":8080")
}
