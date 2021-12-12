package main

import (
	"bufio"
	"fmt"
	// "math"
	"os"
	// "sort"
	// "strconv"
	"strings"
)

func read_std_in() (map[string][]string, map[string]int) {
	s := bufio.NewScanner(os.Stdin)
	paths := make(map[string][]string)
	for i := 0; s.Scan(); i++ {
		path := strings.Split(s.Text(), "-")
		if path[1] != "start" && path[0] != "end" {
			paths[ path[0] ] = append(paths[path[0]], path[1])
		}
		if path[0] != "start" && path[1] != "end" {
			paths[ path[1] ] = append(paths[path[1]], path[0])
		}
	}

	small_caves := make(map[string]int)
	for cave,_ := range paths {
		if is_lower(cave) {
			small_caves[cave] = 0
		}
	}

	return paths, small_caves
}

func main() {

	paths, cave_types := read_std_in()
	
	current_path := make([]string, 0)
	path_count := traverse(paths, cave_types, current_path, "start")

	
	fmt.Println("Path count:", path_count)

}


func traverse(paths map[string][]string, small_caves map[string]int, path []string, cave string) int {
	if cave == "end" {
		path = append(path, cave)
		return 1
	}
	if is_lower(cave) && small_caves[cave] > 0 {
		return 0
	}

	path_count := 0
	path = append(path, cave)
	small_caves[cave]++
	for _,next_cave := range paths[cave] {
		path_count += traverse(paths, small_caves, path, next_cave)
	}
	small_caves[cave] = 0

	return path_count
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