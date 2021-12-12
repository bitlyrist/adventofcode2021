package main

import (
	"bufio"
	"fmt"
	// "math"
	"os"
	// "sort"
	"strconv"
	"strings"
)

func read_std_in() [][]int {
	s := bufio.NewScanner(os.Stdin)
	iinput := make([][]int, 0)
	for i := 0; s.Scan(); i++ {
		sinput := strings.Split(s.Text(), "")
		tmp := make([]int, 0)
		for _, snum := range sinput {
			num, _ := strconv.Atoi(snum)
			tmp = append(tmp, num)
		}
		iinput = append(iinput, tmp)
	}
	return (iinput)
}

func main() {

	octos := read_std_in()
	// print_array(octos)
	
	flashes := 0
	
	i := true
	steps := 1
	for i {

		flashed := make([][]int, len(octos) )
		for f := range flashed {
			flashed[f] = make([]int, len(octos[0]))
		}
		
		for y, line := range octos {
			for x, _ := range line {
				octos[y][x]++
			}
		}
		
		for y, line := range octos {
			for x, octo := range line {
				if octo > 9 {
					flash(&octos, &flashed, y, x, &flashes)
				}
			}
		}

		allflashed := all_flashed(octos)
		if ( allflashed ) {
			i = false
		} else {
			steps++
		}

	}

	
	fmt.Println("Step all flased:", steps)

}

func flash(octos *[][]int, flashed *[][]int, y int, x int, flashes *int) {
	if y < 0 || x < 0 || y >= len(*octos) || x >= len((*octos)[0]) {
		return
	}
	if (*flashed)[y][x] == 0 {
		(*octos)[y][x]++
		// fmt.Println("increment from flash", y, x);
	}
	if (*octos)[y][x] < 10 {
		return
	}

	(*octos)[y][x] = 0
	(*flashed)[y][x] = 1
	(*flashes)++

	flash(octos, flashed, y-1, x-1, flashes)
	flash(octos, flashed, y-1, x, flashes)
	flash(octos, flashed, y-1, x+1, flashes)
	flash(octos, flashed, y, x-1, flashes)
	flash(octos, flashed, y, x+1, flashes)
	flash(octos, flashed, y+1, x-1, flashes)
	flash(octos, flashed, y+1, x, flashes)
	flash(octos, flashed, y+1, x+1, flashes)
	
}

func all_flashed(octos [][]int) bool {
	for y, line := range octos {
		for x, _ := range line {
			if octos[y][x] != 0 {
				return false;
			}
		}
	}
	return true;
}

func print_array(myArray [][]int) {
	for index,element := range myArray {
		fmt.Println(index,"=>",element)
	}
	fmt.Println("\n")
}