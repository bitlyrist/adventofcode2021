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

func read_std_in() ([][]int, [][]int) {
	s := bufio.NewScanner(os.Stdin)
	dots := make([][]int, 0)
	for i := 0; s.Scan(); i++ {
		// fmt.Println("Scanned line:",s.Text())
		if s.Text() == "" {
			break
		}
		dot := strings.Split(s.Text(), ",")
		xval,_ := strconv.Atoi(dot[0])
		yval,_ := strconv.Atoi(dot[1])
		xyval := make([]int, 0)
		xyval = append(xyval, yval)
		xyval = append(xyval, xval)
		dots = append(dots, xyval )
	}

	folds := make([][]int, 0)
	for j := 0; s.Scan(); j++ {
		line := strings.Split(s.Text(), " ")
		foldstr := strings.Split(line[2], "=")
		foldint,_ := strconv.Atoi(foldstr[1]);
		newfold := make([]int, 0)
		if foldstr[0] == "y" {
			newfold = append(newfold, foldint)
			newfold = append(newfold, 0)
		} else {
			newfold = append(newfold, 0)
			newfold = append(newfold, foldint)
		}
		folds = append(folds, newfold)
		
	}

	yval, xval := max_dot(dots)
	paper := make_int_array(yval + 1, xval + 1)
	for _,dot := range dots {
		paper[ dot[0] ][ dot[1] ] = 1
	}

	return paper, folds
}

func main() {

	dots, folds := read_std_in()
	
	// print_int_array(dots)
	// print_int_array(folds)
	

	for _,fold := range folds {

		dots = fold_xy(dots, fold)

		// print_int_array(dots)
	
		break
	}

	// print_int_array(dots)
	
	visible := 0
	for _,line := range dots {
		for _,dot := range line {
			if dot > 0 {
				visible++
			}
		}
	}


	fmt.Println("Visible dot count:", visible)

}


func fold_xy(dots [][]int, fold []int) [][]int {
	if fold[0] > 0 {
		dots = fold_y(dots, fold[0])
	}
	if fold[1] > 0 {
		dots = fold_x(dots, fold[1])
	}
	return dots
}

func fold_x(dots [][]int, fold int) [][]int {
	new_dots := make_int_array(len(dots), fold)
	for y := 0; y < len(dots); y++ {
		for x := fold+1; x < len(dots[y]); x++ {
			new_x := x - (fold+1)
			mirror_x := (fold - 1) - new_x
			new_dots[y][new_x] += dots[y][new_x]
			new_dots[y][mirror_x] += dots[y][x]
		}
	}
	return new_dots
}

func fold_y(dots [][]int, fold int) [][]int {

	new_dots := make_int_array(fold, len(dots[0]))
	for y := fold+1; y < len(dots); y++ {
		for x := 0; x < len(dots[y]); x++ {
			new_y := y - (fold+1)
			mirror_y := (fold - 1) - new_y
			new_dots[new_y][x] += dots[new_y][x]
			new_dots[mirror_y][x] += dots[y][x]
		}
	}
	return new_dots
}


func max_dot(dots [][]int) (int, int) {
	ymax := 0
	xmax := 0
	for _,dot := range dots {
		if dot[0] > ymax {
			ymax = dot[0]
		}
		if dot[1] > xmax {
			xmax = dot[1]
		}
	}
	return ymax, xmax
}


func print_int_array(myArray [][]int) {
	for index,element := range myArray {
		fmt.Println(index,"=>",element)
	}
	fmt.Println("\n")
}

func print_map_string_array(myArray map[string][]string	) {
	for index,element := range myArray {
		fmt.Println(index,"=>",element)
	}
	fmt.Println("\n")
}

func print_map_int_array(myArray map[string][]int	) {
	for index,element := range myArray {
		fmt.Println(index,"=>",element)
	}
	fmt.Println("\n")
}

func is_upper(str string) bool {
	if strings.ToUpper(str) == str {
		return true
	}
	return false
}

func is_lower(str string) bool {
	return !is_upper(str)
}

func make_int_array (y int, x int) [][]int {
	a := make([][]int, 0)
	for i := 0; i < y; i++ {
		row := make([]int, x)
		a = append(a, row)
	}
	return a
}